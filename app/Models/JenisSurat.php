<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class JenisSurat extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_jenis_surat';
  protected $primaryKey = 'id_mst_jenis_surat';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
}
