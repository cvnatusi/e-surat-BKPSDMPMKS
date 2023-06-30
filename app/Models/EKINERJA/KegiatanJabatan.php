<?php

namespace App\Models\EKINERJA;

use Illuminate\Database\Eloquent\Model;

class KegiatanJabatan extends Model
{
	protected $connection = 'ekinerja';
	protected $table = 'opmt_kegiatan_jabatan';
	public $timestamps = false;

}
