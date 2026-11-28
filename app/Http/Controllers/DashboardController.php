<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return match ($this->getActiveRole()) {
            'dokter' => $this->dokterDashboard($request),
            'pasien' => $this->pasienDashboard($request),
            default  => $this->adminDashboard($request),
        };
    }

    private function getActiveRole(): string
    {
        if (auth()->check()) {
            return strtolower(auth()->user()->role ?? 'admin');
        }

        return session('demo_role', 'admin');
    }

    private function adminDashboard(Request $request)
    {
        return view('dashboard.admin', $this->getJadwalData($request));
    }

    private function dokterDashboard(Request $request)
    {
        $search = $request->query('q');$semuaDokter = Dokter::all();
        $dokterId =$request->query('dokter_id');

        if (!$dokterId &&$semuaDokter->isNotEmpty()) {
            $dokterId =$semuaDokter->first()->id_dokter;
        }

        $dokterAktif = $dokterId ? Dokter::find($dokterId) : null;

        $jadwals =$dokterId
            ? JadwalDokter::with(['dokter', 'poli'])->where('id_dokter', $dokterId)->get()
            : collect();

        if ($search) {
            $keyword = strtolower($search);

            $jadwals =$jadwals->filter(function ($jadwal) use ($keyword) {
                $cocokHari = str_contains(strtolower($jadwal->hari), $keyword);$cocokPoli = str_contains(strtolower($jadwal->poli->nama_poli ?? ''), $keyword);

                return $cocokHari ? true : $cocokPoli;
            })->values();
        }

        return view('dashboard.dokter', [
            'semuaDokter' => $semuaDokter,
            'dokterAktif' => $dokterAktif,
            'jadwals'     => $jadwals,
            'search'      => $search,
        ]);
    }

    private function pasienDashboard(Request $request)
    {
        return view('dashboard.pasien', $this->getJadwalData($request));
    }

    private function getJadwalData(Request $request): array
    {
        $search =$request->query('q');
        $poliId =$request->query('poli');
        $hari =$request->query('hari');
        $hasFilter = collect([$search, $poliId,$hari])->filter()->isNotEmpty();

        $jadwals = JadwalDokter::with(['dokter', 'poli'])
            ->when($poliId, fn ($q) => $q->where('id_poli',$poliId))
            ->when($hari, fn ($q) => $q->where('hari',$hari))
            ->when($search, function ($query,$search) {
                $query->where('hari', 'like', "\%{$search}%")
                    ->orWhereHas('dokter', fn ($q) => $q->where('nama_dokter', 'like', "\%{$search}%"))
                    ->orWhereHas('poli', fn ($q) => $q->where('nama_poli', 'like', "\%{$search}%"));
            })
            ->get();

        return [
            'jadwals'   => $jadwals,
            'polis'     => Poli::all(),
            'poliId'    => $poliId,
            'hari'      => $hari,
            'search'    => $search,
            'hasFilter' => $hasFilter,
        ];
    }
}
