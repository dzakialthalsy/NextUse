<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyaratKetentuanController;
use App\Http\Controllers\ReportUserController;
use App\Http\Controllers\ReportItemController;

Route::get('/', function () {
    return view('beranda');
})->name('home');

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'index'])->name('syarat-ketentuan');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/report-user', [ReportUserController::class, 'create'])->name('report-user.create');
Route::post('/report-user', [ReportUserController::class, 'store'])->name('report-user.store');

Route::get('/report-item', [ReportItemController::class, 'create'])->name('report-item.create');
Route::post('/report-item', [ReportItemController::class, 'store'])->name('report-item.store');