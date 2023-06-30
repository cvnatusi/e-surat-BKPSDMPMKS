<?php

namespace App\Models\TAPMAN;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
	protected $connection = 'tapman';
	protected $table = 'userinfo';
	public $timestamps = false;
	public function dept()
  {
      return $this->belongsTo('App\Models\TAPMAN\Department', 'deptid');
  }

}
