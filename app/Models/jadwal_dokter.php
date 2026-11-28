<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwal_dokter extends Model
{
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_dokter',
        'id_poli',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'id_poli');
    }

    public function pendaftaran()
{
    return $this->hasMany(Pendaftaran::class, 'id_jadwal', 'id_jadwal');
}
}