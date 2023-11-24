<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class PenandaTanganSurat extends Model
{
    use SoftDeletes,Loggable;

    protected $table = 'penanda_tangan_surat';
    protected $primaryKey = 'id_penanda_tangan_surat';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function pengguna()
    {
        return $this->belongsTo(MasterASN::class, 'pengguna_id', 'id_mst_asn');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'name');
    }


}
