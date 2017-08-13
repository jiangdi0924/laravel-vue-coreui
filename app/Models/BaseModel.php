<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    public $search_field = [''];
}