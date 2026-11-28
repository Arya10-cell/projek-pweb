<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';

    protected $fillable = ['id_user', 'spesialisasi', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user')->withTrashed();

    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}