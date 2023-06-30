<?php

namespace App\Models\TAPMAN;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Laravel\Sanctum\HasApiTokens;
class Pekerjaan extends Authenticatable
{
  use HasApiTokens;
  protected $table = 'tr_pekerjaan';

    // protected $fillable = [
    //     'email',
    //     'password',
    //     'name',
    //     'created_at',
    //     'updated_at',
    // ];
    protected $primaryKey = 'id_tr_pekerjaan';
    public $incrementing = true;
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

}
