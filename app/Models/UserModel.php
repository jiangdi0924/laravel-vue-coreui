<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use Notifiable;

    public $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bsrCategory()
    {
        return $this->belongsToMany('App\Models\spider\spider_bsr_category','user_bsrs','user_id','bsr_id')->withTimestamps();
    }

    public function userKeyword()
    {
        return $this->belongsToMany('App\Models\spider\spider_keyword','user_keywords','user_id','keyword_id')->withTimestamps();
    }

    public function userListing()
    {
        return $this->belongsToMany('App\Models\spider\spider_listing','user_listings','user_id','listing_id')->withTimestamps();
    }
}