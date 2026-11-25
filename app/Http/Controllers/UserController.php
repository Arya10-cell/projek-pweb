<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            }))
            ->orderBy('id_user', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('users.create', [
            'roles' => User::ROLES,
            'jenisKelamin' => User::JENIS_KELAMIN,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'no_telp'       => ['nullable', 'string', 'max:20'],
            'alamat'        => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', Rule::in(User::JENIS_KELAMIN)],
            'role'          => ['required', Rule::in(User::ROLES)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => User::ROLES,
            'jenisKelamin' => User::JENIS_KELAMIN,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id_user, 'id_user')],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'no_telp'       => ['nullable', 'string', 'max:20'],
            'alamat'        => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', Rule::in(User::JENIS_KELAMIN)],
            'role'          => ['required', Rule::in(User::ROLES)],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil dihapus.');
    }
}