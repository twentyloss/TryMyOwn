<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use  MustVerifyEmailTrait;
    use Notifiable{
        notify as protected preliminaryNotify;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics(){
       return  $this->hasMany(Topic::class);
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf( $model){
      return $this->id==$model->user_id;
    }

    public function notify($instance)
    {
        if($this->id == Auth::id()){
            return ;
        }

        $this->preliminaryNotify($instance);
        if(method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }
    }
}
