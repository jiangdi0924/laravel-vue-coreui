<?php

namespace App\Http\Controllers\MonitorKeyword;

use App\Models\spider\spider_keyword;
use App\Models\spider\spider_listing;
use App\Models\spider\spider_listing_keyword;
use App\Models\user\user_bsr;
use App\Models\UserModel;
use App\Http\Controllers\Controller;


class KeywordController extends Controller
{
    public function __construct(spider_keyword $model)
    {
        $this->model = $model;
    }

    //监控my keyword首页
    public function keywordList()
    {
        $user_id = request()->user()?request()->user()->id:2;
        $userModel = UserModel::find($user_id);
        $data['per_page'] = request()->input('per_page',2);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $keyword_id = request()->input('keyword_id');
        $where_arr = '';
        if($keyword_id){
            $where_arr ='keyword_id|=|'.$keyword_id;
        }
        
        $spider_keyword_objs = $this->assemble($this->model,$userModel->userKeyword(),$data,$where_arr);
        $arr = [];
        foreach ($spider_keyword_objs as $key => $spider_keyword_obj) {
            //关键词产品数量
            $listing_num = $spider_keyword_obj->listing->count();
            //平均售价
            $avg_amount = round($spider_keyword_obj->listing->avg('amount'),2);
            //平均卖家数量
            $avg_seller_num = round($spider_keyword_obj->listing->avg('seller_num'),2);
            //平均评论数
            $avg_review_count = $listing_num?round($spider_keyword_obj->listing()->get(['amazon_model_id'])->unique('amazon_model_id')->sum('review_count')/$listing_num,2):0;
            
            //平均评论等级
            $avg_review_rate = $listing_num?round($spider_keyword_obj->listing()->get(['amazon_model_id'])->unique('amazon_model_id')->sum('review_rate')/$listing_num,2):0;
            $arr[$key]['keyword_id'] = $spider_keyword_obj->id;
            $arr[$key]['name'] = $spider_keyword_obj->name;
            $arr[$key]['avg_amount'] = $avg_amount;
            $arr[$key]['avg_seller_num'] = $avg_seller_num;
            $arr[$key]['avg_review_count'] = $avg_review_count;
            $arr[$key]['avg_review_rate'] = $avg_review_rate;
        }
    
        $page_info_arr = $spider_keyword_objs->toArray();
        unset($page_info_arr['data']);
        $result = $page_info_arr;
        $result['data'] = $arr;

        return response()->json($result);
    }

    public function keywordDetail()
    {
        $keyword_id = request()->input('keyword_id');
        $data['per_page'] = request()->input('per_page',1);
        $data['current_page'] = request()->input('page',1);
        $data['sort'] = request()->input('sort','id|asc');
        $obj = spider_listing_keyword::where('keyword_id',$keyword_id)->where('rate','<',101);
        $spider_listing_keyword_obj = $this->assemble($this->model,$obj,$data);
        $arr = [];
        foreach($spider_listing_keyword_obj as $key=>$_spider_listing_keyword_obj){
            $result = spider_listing::where('id',$_spider_listing_keyword_obj->listing_id)->get()->first()->toArray();
            $rate = spider_listing_keyword::where('keyword_id',$keyword_id)->where('listing_id',$_spider_listing_keyword_obj->listing_id)->get(['rate'])->first();
            $arr[$key]['rate'] = $rate->rate;
            $arr[$key]['name'] = $result['name'];
            $arr[$key]['asin'] = $result['asin'];
            $arr[$key]['listing_id'] = $result['id'];
            $arr[$key]['img'] = $result['img'];
            $arr[$key]['brand'] = $result['brand'];
            $arr[$key]['seller_num'] = $result['seller_num'];
            $arr[$key]['review_rate'] = $result['review_rate'];
            $arr[$key]['is_monitor'] = $result['is_monitor'];    
        }
        $page_info_arr = $spider_listing_keyword_obj->toArray();
        unset($page_info_arr['data']);
        $result = $page_info_arr;
        $result['data'] = $arr;
        
        return response()->json($result);
    }

    public function keywordAdd()
    {
        $data['keyword'] = request()->input('keyword');
        $data['user_id'] = request()->user()->id;
        if(!$data['keyword']){
            return response()->json(['response'=>'keyword empty']);
        }
        $spider_keyword_model=spider_keyword::firstOrCreate(['name'=>$data['keyword']]);
        /*if(array_key_exists('deleted_at',$spider_keyword_model)){
            return response()->json(['response'=>'keyword has added']);
        }*/
        
        $data['keyword_id'] = $spider_keyword_model->id;
        $spider_keyword_model->user()->sync($data['user_id']);
        return response()->json(['response'=>'1']);
    }

    

}
