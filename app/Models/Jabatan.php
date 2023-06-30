<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Jabatan extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_jabatan';
  protected $primaryKey = 'id_mst_jabatan';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
}
