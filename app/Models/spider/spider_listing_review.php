<?php

namespace App\Models\spider;

use App\Models\BaseModel;

class spider_listing_review extends BaseModel
{
    protected $guarded = [];
    protected $appends = ['tag'];
    protected $hidden = ['reviewTag'];

    public function reviewTag()
    {
        return $this->hasMany('App\Models\user\user_listing_review_tag','review_id');
    }

    public function getTagAttribute()
	{
	    return $this->reviewTag->where('user_id',1);
	}

}
