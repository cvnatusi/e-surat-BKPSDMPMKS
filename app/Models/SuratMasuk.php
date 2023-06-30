<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratMasuk extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'tr_surat_masuk';
  protected $primaryKey = 'id_surat_masuk';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

  public function sifat()
  {
      return $this->belongsTo('App\Models\SifatSurat', 'sifat_surat_id');
  }
  public function jenis()
  {
      return $this->belongsTo('App\Models\JenisSurat', 'jenis_surat_id');
  }
  public function pengirim()
  {
      return $this->belongsTo('App\Models\Instansi', 'pengirim_surat_id');
  }
}
