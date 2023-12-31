<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Spatie\Permission\Traits\HasRoles;
class Users extends Authenticatable
{

    use Notifiable,Loggable,HasRoles;
    protected $fillable = [
        'email',
        'password',
        'name',
        'level_user',
        'created_at',
        'updated_at',
        'foto',
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guard_name = 'web';

    public function penanda_tangan_surat()
    {
        return $this->hasMany(PenandaTanganSurat::class);
    }

    public function users()
    {
        return $this->belongsTo(Users::class,  'name');
    }
}
