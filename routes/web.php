<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\AntreanController;

Route::prefix('antrean')->name('antrean.')->controller(AntreanController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/terbitkan', 'create')->name('create');
    Route::post('/terbitkan', 'store')->name('store');
    Route::post('/panggil-berikutnya', 'panggilBerikutnya')->name('panggil-berikutnya');
    Route::get('/{id}', 'show')->name('show')->whereNumber('id');
    Route::patch('/{id}/panggil', 'panggil')->name('panggil')->whereNumber('id');
    Route::patch('/{id}/status', 'updateStatus')->name('status')->whereNumber('id');
});
Route::resource('poli', PoliController::class)
    ->except(['show'])
    ->parameters(['poli' => 'poli']);
Route::get('/', function () {
    return view('welcome');
});
