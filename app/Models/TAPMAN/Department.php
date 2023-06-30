<?php

namespace App\Models\TAPMAN;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $connection = 'tapman';
	protected $table = 'departments';
	public $timestamps = false;
	protected $primaryKey = 'deptid';
	public $keyType = 'string';
	public function finger()
	{
			return $this->belongsTo('App\Models\TAPMAN\MesinFinger', 'parentid');
	}
}
