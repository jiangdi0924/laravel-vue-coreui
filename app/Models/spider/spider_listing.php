<?php

namespace App\Models\spider;

use App\Models\BaseModel;

class spider_listing extends BaseModel
{
    protected $hidden = ['model','seller','productInfo','detail'];
    protected $guarded = [];
    protected $appends = ['review_count','review_rate','seller_num','color','size','is_monitor'];
    public $search_field = ['asin','name','seller_name','brand'];

    public function model()
    {
        return $this->belongsTo('App\Models\spider\spider_amazon_model','amazon_model_id');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\spider\spider_listing_detail','listing_id');
    }

    public function bsrCategory()
    {
        return $this->belongsToMany('App\Models\spider\spider_bsr_category','spider_listing_bsrs','listing_id','bsr_category_id')->withPivot('id')->withTimestamps();
    }

    public function seller()
    {
        return $this->belongsToMany('App\Models\spider\spider_seller','spider_listing_sellers','listing_id','seller_id')->withPivot('is_main','seller_type','currency','amount','shipping_fee','fulfillment')->withTimestamps();
    }

    public function productInfo()
    {
        return $this->hasMany('App\Models\spider\spider_listing_attribute','listing_id');
    }

    public function review()
    {
        return $this->hasMany('App\Models\spider\spider_listing_review','listing_id');
    }	

    public function getIsMonitorAttribute()
    {
        return request()->user()?($this->user()->where('user_id',request()->user()->id)?$this->user()->where('user_id',request()->user()->id)->count():0):0;
    }		  

    public function getReviewCountAttribute()
	{
	    return $this->model?$this->model->review_count:0;
	}

	public function getReviewRateAttribute()
	{
	    return $this->model?$this->model->review_rate:0;
	}

	public function getBsrRateAttribute()
	{
	    return $this->model?$this->model->bsrCategory:'';
	}

	public function getSellerNumAttribute()
	{ 
	    return count($this->seller);
	}

	public function getColorAttribute()
    {
        return $this->productInfo->where('name','Color')->first()?$this->productInfo->where('name','Color')->first()->value:'';
    }

    public function getSizeAttribute()
    {
        return $this->productInfo->where('name','Size')->first()?$this->productInfo->where('name','Size')->first()->value:'';
    }

    public function getInfoAttribute()
    {
        return $this->productInfo->where('is_attribute','1');
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\UserModel','user_listings','listing_id','user_id')->withTimestamps();
    }

}
