<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MisCvController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/buscar', [MisCvController::class, 'index'])->name('cv.index');
Route::get('/cv/export/csv', [MisCvController::class, 'exportCsv'])->name('cv.export.csv');
Route::get('/cv/export/json', [MisCvController::class, 'exportJson'])->name('cv.export.json');

