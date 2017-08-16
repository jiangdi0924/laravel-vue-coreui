<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //监控商品首页
    public function assemble($model,$obj=NULL,$data=NULL,$where_arr=NULL)
    {
        $obj = $obj?$obj:$model;
        $filter = request()->input('filter');
    	$search_field = $model->search_field;
        
    	if($where_arr){
    		$where_arr = explode('|',$where_arr);
    		$obj = $obj->where($where_arr[0],$where_arr[1],$where_arr[2]);
    	}
        if($filter){
            if(!empty($search_field)){
                $obj = $obj->where(function($q) use ($filter,$search_field){
                    foreach($search_field as $field){
                        $q = $q->orWhere($field,$filter);
                    }
                });
            }
        }
        if($data['sort']){
            $sort_arr = explode('|',$data['sort']);
            $obj = $obj->orderBy($sort_arr[0],$sort_arr[1]);
        }
		return $obj->paginate($data['per_page'],['*'],'page',$data['current_page']);	        
    }
 
}
