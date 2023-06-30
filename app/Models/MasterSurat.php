<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MasterSurat extends Model
{
  use SoftDeletes;

  protected $table = 'mst_surat';
  protected $primaryKey = 'id_mst_surat';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
  public function jenisSurat()
  {
      return $this->belongsTo('App\Models\JenisSurat', 'jenis_surat_id');
  }
}
