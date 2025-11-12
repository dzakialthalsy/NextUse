<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SyaratKetentuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('beranda');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/filter', [FilterController::class, 'index'])->name('filter');

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/syarat-ketentuan', [SyaratKetentuanController::class, 'index'])->name('syarat-ketentuan');
Route::get('/inventory', [ItemController::class, 'index'])->name('inventory.index');