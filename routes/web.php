<?php

use App\Http\Controllers\JadwalDokterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('jadwal-dokter', JadwalDokterController::class);
