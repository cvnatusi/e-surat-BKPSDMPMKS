<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class TimelineSuratMasuk extends Model
{
    use SoftDeletes,Loggable;

    protected $table = 'timeline_surat_masuk';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $dates = ['deleted_at'];
}
