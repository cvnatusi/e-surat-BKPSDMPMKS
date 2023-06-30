<?php

namespace App\Models\TAPMAN;

use Illuminate\Database\Eloquent\Model;

class MesinFinger extends Model
{
	protected $connection = 'tapman';
	protected $table = 'iclock';
	public $timestamps = false;
	protected $primaryKey = 'areaid';
	public $keyType = 'string';
}
