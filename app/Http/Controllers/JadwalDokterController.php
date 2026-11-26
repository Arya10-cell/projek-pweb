<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with(['dokter', 'poli'])->get();
        return view('jadwal_dokter.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::all();
        $polis = Poli::all();
        return view('jadwal_dokter.create', compact('dokters', 'polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_dokter' => 'required|exists:dokter,id_dokter',
            'id_poli' => 'required|exists:poli,id_poli',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota_pasien' => 'required|integer|min:1',
        ]);

        JadwalDokter::create($validated);

        return redirect()->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $dokters = Dokter::all();
        $polis = Poli::all();
        return view('jadwal_dokter.edit', compact('jadwal', 'dokters', 'polis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_dokter' => 'required|exists:dokter,id_dokter',
            'id_poli' => 'required|exists:poli,id_poli',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota_pasien' => 'required|integer|min:1',
        ]);

        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->update($validated);

        return redirect()->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal-dokter.index')
            ->with('success', 'Jadwal dokter berhasil dihapus.');
    }
}
