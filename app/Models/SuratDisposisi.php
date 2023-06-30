<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratDisposisi extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'tr_surat_disposisi';
  protected $primaryKey = 'id_surat_disposisi';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

  public function suratMasukId()
  {
      return $this->belongsTo('App\Models\SuratMasuk', 'surat_masuk_id');
  }
  public function pemberi()
  {
      return $this->belongsTo('App\Models\MasterASN', 'pemberi_disposisi_id');
  }
  public function penerima()
  {
      return $this->belongsTo('App\Models\MasterASN', 'penerima_disposisi_id');
  }
}
