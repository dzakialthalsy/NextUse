<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SyaratKetentuanController;
use App\Http\Controllers\ReportUserController;
use App\Http\Controllers\ReportItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('beranda');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/filter', [FilterController::class, 'index'])->name('filter');

Route::get('/', function () {
    return view('beranda');
})->name('home');

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'index'])->name('syarat-ketentuan');

Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/inventory', [ItemController::class, 'index'])->name('inventory.index');

Route::get('/report-user', [ReportUserController::class, 'create'])->name('report-user.create');
Route::post('/report-user', [ReportUserController::class, 'store'])->name('report-user.store');

Route::get('/report-item', [ReportItemController::class, 'create'])->name('report-item.create');
Route::post('/report-item', [ReportItemController::class, 'store'])->name('report-item.store');