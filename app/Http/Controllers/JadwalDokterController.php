<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        $search =$request->query('q');
        $poliId =$request->query('poli');
        $hari =$request->query('hari');
        $hasFilter = count(array_filter([$search, $poliId,$hari])) > 0;

        $jadwals = JadwalDokter::with(['dokter', 'poli'])
            ->when($poliId, fn ($q) => $q->where('id_poli',$poliId))
            ->when($hari, fn ($q) => $q->where('hari',$hari))
            ->when($search, function ($query,$search) {
                $query->where('hari', 'like', "\%{$search}%")
                    ->orWhereHas('dokter', fn ($q) => $q->where('nama_dokter', 'like', "\%{$search}%"))
                    ->orWhereHas('poli', fn ($q) => $q->where('nama_poli', 'like', "\%{$search}%"));
            })
            ->get();

        return view('jadwal_dokter.index', [
            'jadwals'   => $jadwals,
            'polis'     => Poli::all(),
            'search'    => $search,
            'poliId'    => $poliId,
            'hari'      => $hari,
            'hasFilter' => $hasFilter,
        ]);
    }

    public function create()
    {
        return view('jadwal_dokter.create', [
            'dokters' => Dokter::all(),
            'polis'   => Poli::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateJadwal($request);

        JadwalDokter::create($validated);

        return redirect()
            ->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('jadwal_dokter.edit', [
            'jadwal'  => JadwalDokter::findOrFail($id),
            'dokters' => Dokter::all(),
            'polis'   => Poli::all(),
        ]);
    }

    public function update(Request $request,$id)
    {
        $validated = $this->validateJadwal($request);

        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->update($validated);

        return redirect()
            ->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);$jadwal->delete();

        return redirect()
            ->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil dihapus.');
    }

    private function validateJadwal(Request $request): array
    {
        return $request->validate([
            'id_dokter'    => 'required|exists:dokter,id_dokter',
            'id_poli'      => 'required|exists:poli,id_poli',
            'hari'         => 'required|string|max:20',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required|after:jam_mulai',
            'kuota_pasien' => 'required|integer|min:1',
        ]);
    }
}
