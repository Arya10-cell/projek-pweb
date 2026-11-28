<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poli';
    protected $primaryKey = 'id_poli';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
    ];

    public function jadwal()
    {
        return $this->hasMany(JadwalDokter::class, 'id_poli', 'id_poli');
    }
}