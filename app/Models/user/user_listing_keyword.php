<?php

namespace App\Models\user;

use App\Models\BaseModel;

class user_listing_keyword extends BaseModel
{
    protected $guarded = [];
    public $search_field = ['name'];
}
