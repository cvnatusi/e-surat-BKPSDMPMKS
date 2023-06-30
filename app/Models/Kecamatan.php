<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'kabupaten_id');
    }
}
