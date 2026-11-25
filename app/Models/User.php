<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telp',
        'alamat',
        'jenis_kelamin',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const ROLES = ['pasien', 'dokter', 'admin'];
    public const JENIS_KELAMIN = ['Laki-laki', 'Perempuan'];
}