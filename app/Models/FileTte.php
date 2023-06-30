<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class FileTte extends Model
{
    use HasFactory,Loggable;
    protected $table = 'tr_file_tte';
    protected $fillable = ['nama_surat', 'tanggal_surat', 'penanda_tangan_id', 'file_surat','file_surat_salinan','is_verif'];
    protected $primaryKey = 'id_file_surat';

    public function users()
    {
        return $this->belongsTo('App\Models\Users', 'penanda_tangan_id');
    }
}
