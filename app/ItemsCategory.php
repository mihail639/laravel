<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ItemsCategory extends Model
{
    protected $table = 'items_category';
    public $orderType = 'Категории товаров';
    //public $timestamps = false;
}
