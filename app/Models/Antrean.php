<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class Antrean extends Model
{
    public const MENUNGGU   = 'menunggu';
    public const DIPANGGIL  = 'dipanggil';
    public const SELESAI    = 'selesai';
    public const BATAL      = 'batal';
    public const STATUS     = [self::MENUNGGU, self::DIPANGGIL, self::SELESAI, self::BATAL];

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
            'tanggal_antrean' => 'date',
            'waktu_dipanggil' => 'date',
        ];
    }

    /** Gabungkan antrean dengan pasien, dokter, poli, dan keluhan. */
    public function scopeDenganDetail(Builder $query): Builder
    {
        return $query
            ->join('pendaftaran', 'antrean.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('user', 'pendaftaran.id_user', '=', 'user.id_user')
            ->join('jadwal_dokter', 'pendaftaran.id_jadwal', '=', 'jadwal_dokter.id_jadwal')
            ->join('dokter', 'jadwal_dokter.id_dokter', '=', 'dokter.id_dokter')
            ->join('poli', 'jadwal_dokter.id_poli', '=', 'poli.id_poli')
            ->select(
                'antrean.*',
                'pendaftaran.keluhan',
                'pendaftaran.tanggal_kunjungan',
                'user.nama as nama_pasien',
                'user.no_telepon as telepon_pasien',
                'dokter.nama_dokter',
                'poli.id_poli',
                'poli.nama_poli',
                'jadwal_dokter.jam_mulai',
                'jadwal_dokter.jam_selesai'
            );
    }

    /**
     * Terbitkan nomor antrean untuk satu pendaftaran.
     * Nomor berurutan per poli per tanggal kunjungan, dan dicek terhadap kuota jadwal.
     * Method ini juga bisa dipanggil modul Daftar Berobat setelah pendaftaran tersimpan.
     */
    public static function terbitkan(int $idPendaftaran): self
    {
        return DB::transaction(function () use ($idPendaftaran) {
            $sudahAda = self::where('id_pendaftaran', $idPendaftaran)->first();
            if ($sudahAda) {
                return $sudahAda;
            }

            $daftar = DB::table('pendaftaran')
                ->join('jadwal_dokter', 'pendaftaran.id_jadwal', '=', 'jadwal_dokter.id_jadwal')
                ->where('pendaftaran.id_pendaftaran', $idPendaftaran)
                ->select(
                    'pendaftaran.tanggal_kunjungan',
                    'jadwal_dokter.id_jadwal',
                    'jadwal_dokter.id_poli',
                    'jadwal_dokter.kuota_pasien'
                )
                ->first();

            if (! $daftar) {
                throw new RuntimeException('Data pendaftaran tidak ditemukan.');
            }

            // Kunci baris poli supaya dua pendaftaran bersamaan tidak mendapat nomor kembar.
            DB::table('poli')->where('id_poli', $daftar->id_poli)->lockForUpdate()->first();

            $terpakai = DB::table('antrean')
                ->join('pendaftaran', 'antrean.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
                ->where('pendaftaran.id_jadwal', $daftar->id_jadwal)
                ->whereDate('antrean.tanggal_antrean', $daftar->tanggal_kunjungan)
                ->where('antrean.status_antrean', '!=', self::BATAL)
                ->count();

            if ($terpakai >= $daftar->kuota_pasien) {
                throw new RuntimeException('Kuota pasien pada jadwal ini sudah penuh.');
            }

            $terakhir = DB::table('antrean')
                ->join('pendaftaran', 'antrean.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
                ->join('jadwal_dokter', 'pendaftaran.id_jadwal', '=', 'jadwal_dokter.id_jadwal')
                ->where('jadwal_dokter.id_poli', $daftar->id_poli)
                ->whereDate('antrean.tanggal_antrean', $daftar->tanggal_kunjungan)
                ->max('antrean.nomor_antrean');

            return self::create([
                'id_pendaftaran'  => $idPendaftaran,
                'nomor_antrean'   => ($terakhir ?? 0) + 1,
                'tanggal_antrean' => $daftar->tanggal_kunjungan,
                'status_antrean'  => self::MENUNGGU,
            ]);
        });
    }
}