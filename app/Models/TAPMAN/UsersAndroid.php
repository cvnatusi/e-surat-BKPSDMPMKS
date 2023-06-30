<?php

namespace App\Models\TAPMAN;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
class UsersAndroid extends Authenticatable
{
  use HasApiTokens;
  protected $table = 'users_android';

    // protected $fillable = [
    //     'email',
    //     'password',
    //     'name',
    //     'created_at',
    //     'updated_at',
    // ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

}
