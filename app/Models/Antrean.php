<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
     protected $table = 'antrean';
    protected $primaryKey = 'id_antrean';

    protected $fillable = [
        'id_pendaftaran',
        'nomor_antrean',
        'tanggal_antrean',
        'status_antrean',
        'waktu_dipanggil',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_antrean' => 'datetime',
            'waktu_dipanggil' => 'datetime',
        ];
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}