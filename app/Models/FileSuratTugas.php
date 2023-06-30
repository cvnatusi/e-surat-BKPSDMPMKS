<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class FileSuratTugas extends Model
{
  // use SoftDeletes;

  protected $table = 'tr_file_surat_perjalanan_dinas';
  protected $primaryKey = 'id_file_perjalanan_dinas';
  public $timestamps = true;
  // protected $dates = ['deleted_at'];

  public function surattugas()
  {
      return $this->belongsTo('App\Models\SuratTugas', 'surat_tugas_id');
  }
  public function pegawai()
  {
      return $this->belongsTo('App\Models\MasterASN', 'asn_id');
  }
}
