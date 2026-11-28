<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin'  => redirect('/admin/dashboard'),
                'dokter' => redirect('/dokter/dashboard'),
                default  => redirect('/pasien/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegister()
{
    return view('register');
}

public function register(Request $request)
{
    $data = $request->validate([
        'nama' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:user,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'no_telepon' => ['nullable', 'string', 'max:20'],
        'alamat' => ['nullable', 'string'],
        'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
    ]);

    $user = User::create([
        'nama' => $data['nama'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'no_telepon' => $data['no_telepon'] ?? null,
        'alamat' => $data['alamat'] ?? null,
        'jenis_kelamin' => $data['jenis_kelamin'],
        'role' => 'pasien', // dikunci, tidak dari form
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect('/pasien/dashboard');
}
}

