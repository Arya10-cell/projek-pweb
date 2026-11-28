<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

Route::get('/', fn () => redirect('/login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===== SEMENTARA: hapus kalau dashboard teman sudah jadi =====
Route::middleware('auth')->get('/{role}/dashboard', function ($role) {
    return "Dashboard $role <form method='POST' action='" . route('logout') . "'>"
         . csrf_field() . "<button>Logout</button></form>";
})->whereIn('role', ['admin', 'dokter', 'pasien']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('pasien/{id}/restore', [PasienController::class, 'restore'])->name('pasien.restore');
    Route::resource('pasien', PasienController::class)->except(['show']);
});