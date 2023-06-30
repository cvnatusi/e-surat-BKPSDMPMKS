<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class LogActivity extends Model
{
  // use SoftDeletes;

  protected $table = 'logs';
  protected $primaryKey = 'id';
  public $timestamps = true;
  // protected $dates = ['deleted_at'];
  public function users()
  {
      return $this->belongsTo('App\Models\Users', 'user_id');
  }
}
