<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
    })
    ->middleware('auth')
    ->name('home');

// Auth::routes();

