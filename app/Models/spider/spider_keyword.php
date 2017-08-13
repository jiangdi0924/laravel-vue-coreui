<?php

namespace App\Models\spider;

use App\Models\BaseModel;

class spider_keyword extends BaseModel
{
    protected $guarded = [];
	public $search_field = ['name'];
	
    public function listing()
	{
	    return $this->belongsToMany('App\Models\spider\spider_listing','spider_listing_keywords','keyword_id','listing_id')->withTimestamps();
	}

	public function user()
	{
	    return $this->belongsToMany('App\Models\UserModel','user_keywords','keyword_id','user_id')->withTimestamps();
	}
}
