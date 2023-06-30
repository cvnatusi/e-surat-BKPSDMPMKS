<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class SuratBAST extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'tr_surat_bast';
  protected $primaryKey = 'id_surat_bast';
  public $timestamps = true;
  protected $dates = ['deleted_at'];

}
