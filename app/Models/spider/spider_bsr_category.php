<?php

namespace App\Models\spider;

use App\Models\BaseModel;

class spider_bsr_category extends BaseModel
{
	protected $guarded = [];
	public $search_field = ['name'];
	public function user()
	{
	    return $this->belongsToMany('App\Models\UserModel','user_bsrs','bsr_id','user_id')->withTimestamps();
	}
}
