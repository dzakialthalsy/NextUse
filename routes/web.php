<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyaratKetentuanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'index'])->name('syarat-ketentuan');