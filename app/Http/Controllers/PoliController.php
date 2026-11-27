<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PoliController extends Controller
{
    public function index(Request $request)
    {
        $poli = Poli::query()
            ->when($request->q, fn ($query, $q) => $query->where('nama_poli', 'like', "%{$q}%"))
            ->latest('id_poli')
            ->paginate(10)
            ->withQueryString();

        return view('poli.index', compact('poli'));
    }

    public function create()
    {
        return view('poli.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_poli' => 'required|string|max:255|unique:poli,nama_poli',
            'deskripsi' => 'nullable|string',
        ]);

        Poli::create($data);

        return redirect()->route('poli.index')
            ->with('success', 'Data poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli)
    {
        return view('poli.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $data = $request->validate([
            'nama_poli' => ['required', 'string', 'max:255',
                Rule::unique('poli', 'nama_poli')->ignore($poli->id_poli, 'id_poli')],
            'deskripsi' => 'nullable|string',
        ]);

        $poli->update($data);

        return redirect()->route('poli.index')
            ->with('success', 'Data poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        try {
            $poli->delete();
        } catch (QueryException $e) {
            return redirect()->route('poli.index')
                ->with('error', 'Poli tidak bisa dihapus karena masih dipakai data lain (dokter/jadwal/antrean).');
        }

        return redirect()->route('poli.index')
            ->with('success', 'Data poli berhasil dihapus.');
    }
}