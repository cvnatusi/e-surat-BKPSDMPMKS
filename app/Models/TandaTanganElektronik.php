<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TandaTanganElektronik extends Model
{
    // use SoftDeletes;
    protected $table = 'tr_tandatangan_elektronik';
    protected $fillable = ['pengguna', 'kode_surat', 'nama_badan', 'nama_kepala_badan', 'jabatan', 'nip', 'gambar'];
    protected $primaryKey = 'id';
    // public $timestamps = false;
}
