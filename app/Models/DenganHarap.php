<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class DenganHarap extends Model
{
  use SoftDeletes,Loggable;

  protected $table = 'mst_dengan_harap';
  protected $primaryKey = 'id_mst_dengan_harap';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
}
