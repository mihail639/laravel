<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items'; 
    public $orderType = 'Товары';
    //public $timestamps = false;
}
