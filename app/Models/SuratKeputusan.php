<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratKeputusan extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'tr_surat_keputusan';
  protected $primaryKey = 'id_surat_keputusan';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

}
