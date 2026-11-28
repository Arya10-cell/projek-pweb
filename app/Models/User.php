<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'email', 'password', 'no_telepon',
        'alamat', 'jenis_kelamin', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function dokter()
{
    return $this->hasOne(Dokter::class, 'id_user', 'id_user');
}

    public function pendaftaran()
{
    return $this->hasMany(Pendaftaran::class, 'id_user', 'id_user');
}
}