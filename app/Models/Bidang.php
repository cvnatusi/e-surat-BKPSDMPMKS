<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Bidang extends Model
{
    use SoftDeletes,Loggable;

    protected $table = 'bidang';
    protected $primaryKey = 'id_bidang';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
}
