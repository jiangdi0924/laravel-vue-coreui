<?php

namespace App\Http\Controllers\MonitorBsrCategory;

use App\Models\spider\spider_bsr_category;
use App\Models\spider\spider_listing_bsr;
use App\Models\spider\spider_listing;
use App\Models\user\user_bsr;
use App\Models\user\user_bsr_temp;
use App\Models\UserModel;
use App\Http\Controllers\Controller;


class BsrController extends Controller
{
    public function __construct(spider_bsr_category $model)
    {
        $this->model = $model;
    }

    //监控bsr分类首页
    public function bsrList()
    {
        $user_id = request()->user()->id;
        $userModel = UserModel::find($user_id);
        $data['per_page'] = request()->input('per_page',1);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $bsr_id = request()->input('bsr_id');
        $where_arr = '';
        if($bsr_id){
            $where_arr ='bsr_id|=|'.$bsr_id;
        }
        $bsr_objs = $this->assemble($this->model,$userModel->bsrCategory(),$data,$where_arr);

        $arr = [];
        $id_arr = [];
        foreach ($bsr_objs as $key=>$bsr_obj) {
            $listing_id_arr = spider_listing_bsr::where('bsr_category_id',$bsr_obj->id)->get(['listing_id'])->toArray();
            foreach ($listing_id_arr as $_id_arr) {
                $id_arr[] = $_id_arr['listing_id'];
            }
            //商品平均价格
            $avg_amount = spider_listing::whereIn('id',$id_arr)->avg('amount');
            //商品平均卖家数
            $avg_seller_num = spider_listing::whereIn('id',$id_arr)->avg('seller_num');
            //商品品牌数
            $avg_brand = spider_listing::whereIn('id',$id_arr)->get()->unique('brand')->count();
            //商品评价数
            $listing_review_count = spider_listing::whereIn('id',$id_arr)->get(['amazon_model_id'])->unique('amazon_model_id')->sum('review_count');
            //商品平均评价数
            $avg_listing_review_count = count($id_arr)?round($listing_review_count/count($id_arr),2):0;
            $arr[$key]['bsr_id'] = $bsr_obj->id;
            $arr[$key]['name'] = $bsr_obj->name;
            $arr[$key]['avg_amount'] = round($avg_amount,2);
            $arr[$key]['avg_seller_num'] = round($avg_seller_num,2);
            $arr[$key]['avg_brand'] = $avg_brand;
            $arr[$key]['avg_listing_review_count'] = round($avg_listing_review_count,2);
        }
        $page_info_arr = $bsr_objs->toArray();
        unset($page_info_arr['data']);
        $result = $page_info_arr;
        $result['data'] = $arr;

        return response()->json($result);
    }

    public function bsrDetail()
    {
        $bsr_id = request()->input('bsr_id');
        $data['per_page'] = request()->input('per_page',1);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $obj = spider_listing_bsr::where('bsr_category_id',$bsr_id)->where('rate','<',101);
        $spider_listing_bsr_obj = $this->assemble($this->model,$obj,$data);
        $arr = [];
        foreach($spider_listing_bsr_obj as $key=>$_spider_listing_bsr_obj){
            $result = spider_listing::where('id',$_spider_listing_bsr_obj->listing_id)->get()->first()->toArray();
            $arr[$key]['name'] = $result['name'];
            $arr[$key]['asin'] = $result['asin'];
            $arr[$key]['listing_id'] = $result['id'];
            $arr[$key]['img'] = $result['img'];
            $arr[$key]['brand'] = $result['brand'];
            $arr[$key]['seller_num'] = $result['seller_num'];
            $arr[$key]['review_rate'] = $result['review_rate'];
            $arr[$key]['is_monitor'] = $result['is_monitor'];     
        }
        $page_info_arr = $spider_listing_bsr_obj->toArray();
        unset($page_info_arr['data']);
        $result = $page_info_arr;
        $result['data'] = $arr;
        
        return response()->json($result);
    }

    public function bsrAdd()
    {
        $data['url'] = request()->input('url');
        if(!$data['url']){
            return response()->json(['response'=>'bsr url empty']);
        }
        //curl判断此url的bsr是否已经存在
        $bsr_result = '';
        if($bsr_result){
            //存在
        }else{
            //不存在
            $spider_bsr_category_model = spider_bsr_category::firstOrCreate($data);
            user_bsr_temp::create(['bsr_id'=>$spider_bsr_category_model->id,'url'=>$data['url']]);
            $spider_bsr_category_model->user()->sync(['user_id'=>request()->user()->id]);
        }
    }

    

}
