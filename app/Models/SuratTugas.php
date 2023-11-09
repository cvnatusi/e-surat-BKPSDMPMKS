<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratTugas extends Model
{
	use SoftDeletes,Loggable;

	protected $table = 'tr_surat_perjalanan_dinas';
	protected $primaryKey = 'id_surat_perjalanan_dinas';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	// public function getAsnIdAttribute($value){
	// 	return (int)$value;
	// }
// 	protected $casts = [
// 		'asn_id' => 'integer',
//   ];

	public function suratkeluar()
	{
		return $this->belongsTo('App\Models\SuratKeluar', 'surat_keluar_id');
	}
	public function pegawai()
	{
		return $this->belongsTo('App\Models\MasterASN', 'asn_id', 'id_mst_asn');
	}
	// public function pegawai()
	// {
	// 	return $this->belongsTo('App\Models\MasterASN', 'asn_id');
	// }
	public function tujuan()
	{
		return $this->hasMany('App\Models\TujuanSuratTugas', 'surat_tugas_id', 'id_surat_perjalanan_dinas');
	}
	public function penandatangan()
	{
		return $this->belongsTo('App\Models\MasterASN', 'yang_bertanda_tangan_asn_id');
	}
}
