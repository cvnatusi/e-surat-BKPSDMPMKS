<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratKeluar extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'tr_surat_keluar';
  protected $primaryKey = 'id_surat_keluar';
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
  public function penerima()
  {
      return $this->belongsTo('App\Models\Instansi', 'tujuan_surat_id');
  }
}
