<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TujuanSuratTugas extends Model
{
  use SoftDeletes;

  protected $table = 'tr_tujuan_surat_perjalanan_dinas';
  protected $primaryKey = 'id_tujuan_perjalanan_dinas';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

  public function suratTugas()
  {
      return $this->belongsTo('App\Models\SuratTugas', 'surat_tugas_id', 'id_surat_perjalanan_dinas');
  }
  public function pegawai()
  {
      return $this->belongsTo('App\Models\MasterASN', 'asn_id');
  }
}
