<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelPengguna extends Model
{
    use HasFactory;

    protected $table = 'level_pengguna';
    protected $primaryKey = 'id_level_user';
    protected $guarded = ['id_level_user'];
}
