<?php

use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ReportItemController;
use App\Http\Controllers\ReportUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SyaratKetentuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('beranda');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/filter', [FilterController::class, 'index'])->name('filter');

Route::get('/home', function () {
    return redirect()->route('beranda');
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

Route::get('/post-item', [PostItemController::class, 'create'])->name('post-item.create');
Route::post('/post-item', [PostItemController::class, 'store'])->name('post-item.store');
Route::post('/post-item/save-draft', [PostItemController::class, 'saveDraft'])->name('post-item.save-draft');

Route::controller(ChatMessageController::class)->group(function () {
    Route::get('/chat', 'index')->name('chat.index');
    Route::post('/chat/messages', 'store')->name('chat.store');
    Route::get('/chat/messages/{chatMessage}/edit', 'edit')->name('chat.edit');
    Route::put('/chat/messages/{chatMessage}', 'update')->name('chat.update');
    Route::delete('/chat/messages/{chatMessage}', 'destroy')->name('chat.destroy');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.index');
    Route::get('/profile/{profile}/edit', 'edit')->name('profile.edit');
    Route::put('/profile/{profile}', 'update')->name('profile.update');
    Route::delete('/profile/{profile}', 'destroy')->name('profile.destroy');
});