<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\User;
use App\Models\Users;
class MasterASN extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_asn';
  protected $primaryKey = 'id_mst_asn';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

  // public function tr_surat_perjalanan_dinas()
  // {
  //   return $this->HasMany('App\Models\SuratTugas', 'id_mst_asn');
  // }
	// public function getIdMstAsnAttribute($value){
	// 	return (int)$value;
	// }
  public function jabatan_asn()
  {
    return $this->belongsTo('App\Models\Jabatan', 'jabatan');
  }
  public function user() {
    return $this->HasMany(User::class);
  }
  public function users()
  {
      return $this->belongsTo('App\Models\Users', 'users_id');
  }

  public function ttd_surat()
  {
    return $this->hasMany(PenandaTanganSurat::class, 'pengguna_id');
  }
}
