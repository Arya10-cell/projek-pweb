<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::get('/set-role/{role}', function (string $role) {
    if (in_array($role, ['admin', 'dokter', 'pasien'])) {
        session(['demo_role' => $role]);
    }

    return redirect()->route('dashboard.index');
})->name('role.switch');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('jadwal-dokter', JadwalDokterController::class)->except(['show']);

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
