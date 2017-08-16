<?php

namespace App\Http\Controllers\MonitorProduct;

use Translation;
use App\Http\Controllers\Controller;
use App\Models\spider\calculate;
use App\Models\spider\spider_listing;
use App\Models\spider\spider_listing_review;
use App\Models\spider\spider_keyword;
use App\Models\spider\spider_listing_keyword;
use App\Models\spider\spider_listing_keyword_rate;
use App\Models\user\user_listing_review_tag;
use App\Models\user\user_listing_keyword;
use App\Models\spider\spider_listing_bsr_rate;
use App\Models\UserModel;

class ProductController extends Controller
{
    public function __construct(spider_listing $model)
    {
        $this->model = $model;
    }

    //监控商品首页
    public function productDetail()
    {
        $data = request()->all();
        $data['per_page'] = request()->input('per_page',2);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $data['user_id'] = request()->user()->id;
        $user_model = UserModel::find($data['user_id']);
        $where_arr = '';
        
        $arr = $this->assemble($this->model,$user_model->userListing(),$data,$where_arr);

        return $arr->toJson();
    }

    //添加监控产品
    public function addAsin()
    {
        $string = request()->input('info');
        $user_id = request()->user()?request()->user()->id:2;
        if(strlen($string)==10){
            $data['asin'] = $string; 
        }else{
            preg_match_all("/\/[A-Z0-9]{10}\//", $str, $match);
            if(!count($match[0])){
                $data['asin'] = substr($match[0][0], 1,strlen($match[0][0])-2);
            }else{
                return response()->json(['response'=>'invalid asin or url']);
            }      
        }

        $spider_listing_model = spider_listing::firstOrCreate($data);
        $result = $spider_listing_model->user()->sync([$user_id]);
        return response()->json(['response'=>'1']);
    }

    //取消监控产品
    public function cancelAsin()
    {
        $listing_id = request()->input('listing_id');
        $user_id = request()->user()->id;

        $spider_listing_model = spider_listing::find($listing_id);
        $result = $spider_listing_model->user()->detach([$user_id]);
        //1成功,0失败
        return response()->json(['response'=>$result]);
    }

    //监控产品详情
    public function asinDetail()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id);
        
        return $obj->tojson();
    }

    //监控产品其余卖家信息
    public function asinOtherSeller()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id);
        foreach ($obj->seller as $key=>$_seller) {
            $result[$key]['shipping_fee'] = $_seller->pivot['shipping_fee'];
            $result[$key]['fulfillment'] = $_seller->pivot['fulfillment'];
            $result[$key]['sell_name'] = $_seller->name;
            $result[$key]['amount'] = $_seller->pivot['amount'];
            $result[$key]['logo'] = $_seller->img;
        }
        
        return response()->json($result);
    }

    /**
     * bsr分析
     *
     * @param  listing_id
     * @return bsr_name bsr_rate
     */
    public function bsrInfo()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id);
        $bsr_rate_arr = [];
        $result = [];
        foreach($obj->bsrCategory as $key=>$_obj){
            $bsr_rate_arr[$key]['id'] = $_obj->pivot->id;
            $bsr_rate_arr[$key]['bsr_name'] = $_obj->name;
        }

        foreach($bsr_rate_arr as $key_rate=>$bsr_rate){
            $re = spider_listing_bsr_rate::where('listing_bsr_id',$bsr_rate['id'])->get(['rate','import_date'])->toArray();
            foreach($re as $_re){
                $result[$key_rate]['value'][][$_re['import_date']] = $_re['rate'];
            }
            $result[$key_rate]['name'] = $bsr_rate['bsr_name'];
        }
        
        return response()->json($result);
    }

    //销售分析折线图
    public function graph()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id);
       
        return $obj->detail->where('import_date','<',date('Y-m-d',time()+86400))->groupBy('import_date')->toJson();
    }

    //变体信息
    public function variantList()
    {
        $id = request()->input('amazon_model_id',1);
        $obj = $this->model->where('amazon_model_id',$id)->get()->toJson();
       
        return $obj;
    }

    //评论分析->每日评论变化图
    public function reviewGraph()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id)->review->groupBy('import_date')->where('created_at','<',date('Y-m-d',time()));
        $arr = [];
        foreach($obj as $_obj){
            $key = $_obj->first()->import_date;
            $arr[$key]['total'] = $_obj->count();
        }
        
        return json_encode($arr);
    }

    //评论分析->评分饼状图
    public function reviewPie()
    {
        $id = request()->input('listing_id',1);
        $obj = $this->model->find($id)->review->groupBy('rate')->where('created_at','<',date('Y-m-d',time()));
        $arr = [];
        foreach($obj as $rate=>$_obj){
            $arr[$rate]['count'] = $_obj->count();
        }
        $obj_vp = $this->model->find($id)->review->groupBy('is_vp')->where('created_at','<',date('Y-m-d',time()));
        foreach($obj_vp as $vp=>$_obj_vp){
            $brr[$vp]['count'] = $_obj_vp->count();
        }
        $rate_arr = [1,2,3,4,5];
        foreach($rate_arr as $_rate_arr ){
            if(!array_key_exists($_rate_arr, $arr)){
                $arr[$_rate_arr] = ['count'=>0];
            }
        }
        $is_vp_arr = [0,1];
        foreach($is_vp_arr as $_is_vp_arr ){
            if(!array_key_exists($_is_vp_arr, $brr)){
                $brr[$_is_vp_arr] = ['count'=>0];
            }
        }
        $crr['rate'] = $arr;
        $crr['is_vp'] = $brr;
        
        return json_encode($crr);
    }

    //卖点分析->评论展示
    public function reviewInfo()
    {
        $model = new spider_listing_review();
        $id = request()->input('listing_id',7);
        $data['per_page'] = request()->input('per_page',12);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $obj = $model->where('listing_id',$id);
        $total_obj = $obj->get();
        $where_arr ='listing_id|=|'.$id;
        $paginate_obj = $this->assemble($model,$obj='',$data,$where_arr);
        $result = user_listing_review_tag::where('listing_id',$id)->get()->unique('tag')->toArray();
        foreach ($paginate_obj as $listing_review_model) {
            if(!$listing_review_model->cn_content){
                $result_transfer = Translation::translate($listing_review_model->content);
                $listing_review_model->update(['cn_content'=>$result_transfer['trans_result'][0]['dst']]);
            }
            $listing_review_model->to = $result;

        }
        
        return json_encode($paginate_obj);
    }

    //卖点分析->评论展示
    public function reviewInfoStar()
    {
        $model = new spider_listing_review();
        $id = request()->input('listing_id',1);
        $total_obj = $model->where('listing_id',$id)->get();
        $obj['total_num']  = $total_obj->count();
        $obj['one_rate']  = $total_obj->where('rate','1.0')->count();
        $obj['two_rate']  = $total_obj->where('rate','2.0')->count();
        $obj['three_rate']  = $total_obj->where('rate','3.0')->count();
        $obj['four_rate']  = $total_obj->where('rate','4.0')->count();
        $obj['five_rate']  = $total_obj->where('rate','5.0')->count();

        return json_encode($obj);
    }

    /**
     * listing添加tag
     *
     * @param  listing_id review_id user_id tag is_good
     * @return json
     */
    public function reviewTagInsert()
    {
        $data['listing_id'] = request()->input('listing_id',1);
        $data['user_id'] = request()->user()->id;
        $data['review_id'] = request()->input('review_id',3);
        $data['tag'] = request()->input('tag','22');
        $data['is_good'] = request()->input('is_good','1');
        $result = user_listing_review_tag::firstOrCreate($data);

        if($result->wasRecentlyCreated){
            return json_encode(['response'=>'1']);
        }else{
            return json_encode(['response'=>'0']);
        }
           
    }

    /**
     * 查询当前用户现有listing_review tag
     *
     * @param  listing_id review_id user_id tag is_good
     * @return json
     */
    public function reviewTagShow()
    {
        //$data = request()->all();
        $data['listing_id'] = request()->input('listing_id',1);
        $data['user_id'] = request()->user()->id;

        $data['review_id'] = request()->input('review_id');
        $result = user_listing_review_tag::where('listing_id',$data['listing_id']);
        if($data['review_id']){
            $result = $result->where('review_id',$data['review_id']);
        }

        $result = $result->where('user_id',$data['user_id'])->get()->unique('tag')->toArray();
        
        return response()->json($result);
       
    }

    //listing标签占比评论数
    public function tagDetail()
    {
        $listing_id = request()->input('listing_id',1);
        $listing_model = $this->model->find($listing_id);
        $total_review_count = $listing_model->model->review_count;
        $user_id = request()->user()->id;
        $arr = [];
        $every_tag = user_listing_review_tag::where('user_id',$user_id)->where('listing_id',$listing_id)->get()->groupBy('tag')->toArray();
        foreach ($every_tag as $tag => $value) {
            $temp['tag'] = $tag;
            $temp['is_good'] = $value[0]['is_good'];
            $temp['count'] = count($value);
            $temp['rate'] = round($temp['count']/$total_review_count,5);
            $arr[] = $temp;
        }

        return response()->json($arr);
        
    }

    /**
     * 添加关键词
     *
     * @param  listing_id keywords user_id 
     * @return json
     */
    public function insertKeywords()
    {
        $keywords = request()->input('keywords','测试');
        $data['user_id'] = request()->user()->id;
        $data['listing_id'] = request()->input('listing_id',1);
        $spider_keyword_model=spider_keyword::firstOrCreate(['name'=>$keywords]);
        $data['keyword_id'] = $spider_keyword_model->id;
        $spider_keyword_model->listing()->sync($data['listing_id']);
        $spider_keyword_model->user()->sync($data['user_id']);
        $user_listing_keyword_model = user_listing_keyword::firstOrCreate($data);
    
        return json_encode(1); 
    }

    /**
     * 用户关键词查询
     *
     * @param  listing_id keywords user_id 
     * @return json
     */
    public function userKeywordRate()
    {
        $data['user_id'] = request()->user()->id;
        $data['listing_id'] = request()->input('listing_id',1);
        //查询用户listing添加的关键词
        $keyword_id_arr_boj = user_listing_keyword::where('user_id',$data['user_id'])->where('listing_id',$data['listing_id'])->get(['keyword_id']);
        if(!$keyword_id_arr_boj->count())return response()->json(['response'=>'no keywords']); 
        foreach($keyword_id_arr_boj as $keyword_id_obj){
            $keyword_id_arr[] = $keyword_id_obj->keyword_id;
        }
        $spider_listing_keyword_model = spider_listing_keyword::where('listing_id',$data['listing_id'])->whereIn('keyword_id',$keyword_id_arr)->get();
        $result = [];
        foreach($spider_listing_keyword_model as $key=>$rate){
            $keyword = spider_keyword::find($rate->keyword_id);
            $rate_arr = spider_listing_keyword_rate::where('listing_keyword_id',$rate->id)->get(['import_date','rate'])->first()->toArray();
            $temp['rate'] = $rate_arr['rate'];
            $temp['name'] = $keyword?$keyword->name:'';
            $result[$key] = $temp;
        }
        
        return response()->json($result); 
    }

    /**
     * 用户关键词查询和排名变化
     *
     * @param  listing_id keywords user_id 
     * @return json
     */
    public function userKeywordRateChart()
    {
        $data['user_id'] = request()->user()->id;
        $data['listing_id'] = request()->input('listing_id',1);
        //查询用户listing添加的关键词
        $keyword_id_arr_boj = user_listing_keyword::where('user_id',$data['user_id'])->where('listing_id',$data['listing_id'])->get(['keyword_id']);
        if(!$keyword_id_arr_boj->count())return response()->json(['response'=>'no keywords']); 
        foreach($keyword_id_arr_boj as $keyword_id_obj){
            $keyword_id_arr[] = $keyword_id_obj->keyword_id;
        }
        $result = [];
        $spider_listing_keyword_model = spider_listing_keyword::where('listing_id',$data['listing_id'])->whereIn('keyword_id',$keyword_id_arr)->get();
        foreach($spider_listing_keyword_model as $key=>$rate){
            $keyword = spider_keyword::find($rate->keyword_id);
            $rate_arr = spider_listing_keyword_rate::where('listing_keyword_id',$rate->id)->get(['import_date','rate'])->toArray();
            foreach($rate_arr as $rate_arr_key=>$_rate_arr){
                $crr = [];
                $crr[$_rate_arr['import_date']] = $_rate_arr['rate'];
                $temp['value'][$rate_arr_key] = $crr;
            }
            $temp['name'] = $keyword->name;
            $result[$key] = $temp;
        }

        return response()->json($result); 
    }

    /**
     * 计算listing利润率
     *
     * @param  
     * @return json
     */
    public function calculate()
    {
        $data = request()->all();
        $data['user_id'] = request()->user()->id;
        $calculate_eloquent = calculate::where('listing_id',$data['listing_id'])->where('user_id',$data['user_id']);
        if($calculate_eloquent->count()){
            $calculate_eloquent->update($data);
            return response()->json(['response'=>'update successfully']);
        }else{
            calculate::create($data);
            return response()->json(['response'=>'create successfully']);
        }   

    }

    /**
     * 查询listing利润率
     *
     * @param  
     * @return json
     */
    public function calculateList()
    {
        $data = request()->all();
        $data['user_id'] = request()->user()->id;
        $data['listing_id'] = request()->input('listing_id');
        $calculate = calculate::where('listing_id',$data['listing_id'])->where('user_id',$data['user_id'])->get()->toJson();
        return $calculate;
    }

}
