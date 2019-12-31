<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $table = 'video_category';
    public $orderType = 'Категории видео';
    //public $timestamps = false;
}
