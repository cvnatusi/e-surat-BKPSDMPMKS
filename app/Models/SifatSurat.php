<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SifatSurat extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_sifat_surat';
  protected $primaryKey = 'id_sifat_surat';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
}
