<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoliController;

Route::resource('poli', PoliController::class)
    ->except(['show'])
    ->parameters(['poli' => 'poli']);
Route::get('/', function () {
    return view('welcome');
});
