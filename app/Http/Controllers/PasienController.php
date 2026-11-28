<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PasienController extends Controller
{
    // READ: daftar pasien aktif atau arsip, dengan pencarian
    public function index(Request $request)
    {
        $arsip = $request->boolean('arsip');

        $query = User::where('role', 'pasien');

        if ($arsip) {
            $query->onlyTrashed();
        }

        $daftarPasien = $query
            ->when($request->q, function ($qb, $q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('nama', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('nama')
            ->get();

        return view('admin.pasien.index', compact('daftarPasien', 'arsip'));
    }

    // CREATE: form
    public function create()
    {
        return view('admin.pasien.create');
    }

    // CREATE: simpan (password dibuat otomatis)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:user,email'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ]);

        $passwordSementara = Str::random(8);

        $data['password'] = Hash::make($passwordSementara);
        $data['role'] = 'pasien'; // dikunci

        User::create($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', "Pasien berhasil ditambahkan. Password sementara: {$passwordSementara}");
    }

    // UPDATE: form
    public function edit(User $pasien)
    {
        $this->pastikanPasien($pasien);

        return view('admin.pasien.edit', compact('pasien'));
    }

    // UPDATE: simpan
    public function update(Request $request, User $pasien)
    {
        $this->pastikanPasien($pasien);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('user', 'email')->ignore($pasien->id_user, 'id_user')],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ]);

        $pasien->update($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    // DELETE: soft delete (baris tetap ada, riwayat aman)
    public function destroy(User $pasien)
    {
        $this->pastikanPasien($pasien);

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Pasien dipindahkan ke arsip. Riwayat pendaftarannya tetap tersimpan.');
    }

    // RESTORE: pulihkan pasien dari arsip
    public function restore($id)
    {
        $pasien = User::onlyTrashed()->where('role', 'pasien')->findOrFail($id);
        $pasien->restore();

        return redirect()->route('admin.pasien.index', ['arsip' => 1])
            ->with('success', 'Pasien berhasil dipulihkan.');
    }

    // Cegah admin mengubah akun non-pasien lewat URL
    private function pastikanPasien(User $user): void
    {
        abort_unless($user->role === 'pasien', 404);
    }
}