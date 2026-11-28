<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_user',
        'id_jadwal',
        'tanggal_pendaftaran',
        'status_pendaftaran',
        'tanggal_kunjungan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pendaftaran' => 'datetime',
            'tanggal_kunjungan' => 'date',
        ];
    }

    public function user()
    {
       return $this->belongsTo(User::class, 'id_user', 'id_user')->withTrashed();
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalDokter::class, 'id_jadwal', 'id_jadwal');
    }

    public function antrean()
    {
        return $this->hasOne(Antrean::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}