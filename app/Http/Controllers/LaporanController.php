<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $poliId = $request->query('poli');
        $hari = $request->query('hari');
        $hasFilter = collect([$search, $poliId, $hari])->filter()->isNotEmpty();

        $rekap = $this->getRekapData($request);
        $jadwalByPoli = JadwalDokter::all()->groupBy('id_poli');

        $rekapPerPoli = Poli::all()->map(function ($poli) use ($jadwalByPoli) {
            $list = $jadwalByPoli->get($poli->id_poli, collect());

            $poli->jumlah_dokter = $list->pluck('id_dokter')->unique()->count();
            $poli->jumlah_jadwal = $list->count();
            $poli->total_kuota = $list->sum('kuota_pasien');

            return $poli;
        });

        return view('laporan.index', [
            'rekap'            => $rekap,
            'rekapPerPoli'     => $rekapPerPoli,
            'polis'            => Poli::all(),
            'poliId'           => $poliId,
            'hari'             => $hari,
            'search'           => $search,
            'hasFilter'        => $hasFilter,
            'totalPendaftaran' => Schema::hasTable('pendaftaran') ? DB::table('pendaftaran')->count() : 0,
            'totalAntrean'     => Schema::hasTable('antrean') ? DB::table('antrean')->count() : 0,
            'totalJadwal'      => $rekap->count(),
            'totalKuota'       => $rekap->sum('kuota_pasien'),
        ]);
    }

    public function export(Request $request)
    {
        $rekap = $this->getRekapData($request);
        $filename = 'laporan-rekap-antrinik-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($rekap) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'No', 'Poli', 'Dokter', 'Spesialisasi',
                'Hari', 'Jam Praktik', 'Terdaftar', 'Kuota', 'Utilisasi', 'Status',
            ]);

            foreach ($rekap as $index => $item) {
                $jam = substr($item->jam_mulai, 0, 5) . ' - ' . substr($item->jam_selesai, 0, 5);

                fputcsv($handle, [
                    $index + 1,
                    $item->poli->nama_poli ?? '-',
                    $item->dokter->nama_dokter ?? '-',
                    $item->dokter->spesialisasi ?? '-',
                    ucfirst($item->hari),
                    $jam,
                    $item->total_terdaftar,
                    $item->kuota_pasien,
                    $item->utilisasi_persen . '%',
                    $item->status_kuota,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function getRekapData(Request $request)
    {
        $poliId = $request->query('poli');
        $hari = $request->query('hari');
        $search = $request->query('q');

        $jadwals = JadwalDokter::with(['dokter', 'poli'])
            ->when($poliId, fn ($q) => $q->where('id_poli', $poliId))
            ->when($hari, fn ($q) => $q->where('hari', $hari))
            ->when($search, function ($query, $search) {
                $query->where('hari', 'like', "%{$search}%")
                    ->orWhereHas('dokter', fn ($q) => $q->where('nama_dokter', 'like', "%{$search}%"))
                    ->orWhereHas('poli', fn ($q) => $q->where('nama_poli', 'like', "%{$search}%"));
            })
            ->get();

        $pendaftaranPerJadwal = [];

        if (Schema::hasTable('pendaftaran') && Schema::hasColumn('pendaftaran', 'id_jadwal')) {
            $pendaftaranPerJadwal = DB::table('pendaftaran')
                ->select('id_jadwal', DB::raw('COUNT(*) as total'))
                ->groupBy('id_jadwal')
                ->pluck('total', 'id_jadwal')
                ->toArray();
        }

        return $jadwals->map(function ($jadwal) use ($pendaftaranPerJadwal) {
            $terdaftar = (int) ($pendaftaranPerJadwal[$jadwal->id_jadwal] ?? 0);
            $kuota = max(1, (int) $jadwal->kuota_pasien);

            $jadwal->total_terdaftar = $terdaftar;
            $jadwal->utilisasi_persen = min(100, (int) round(($terdaftar / $kuota) * 100));
            $jadwal->status_kuota = match (true) {
                $terdaftar >= $kuota => 'PENUH',
                $terdaftar > 0       => 'BERJALAN',
                default              => 'TERSEDIA',
            };

            return $jadwal;
        });
    }
}
