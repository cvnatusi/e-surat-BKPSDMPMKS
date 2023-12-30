<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Instansi extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_instansi';
  protected $guarded = ['id_instansi'];
  protected $primaryKey = 'id_instansi';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

  public function kabupaten()
  {
      return $this->belongsTo('App\Models\Kabupaten', 'nama_kota');
  }
}
