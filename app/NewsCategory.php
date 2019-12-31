<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_category';
    public $orderType = 'Категории новостей';
    //public $timestamps = false;
}
