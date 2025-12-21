<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenilaianLayananController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth');                //Halaman login
Route::post('/auth', [AuthController::class, 'login'])->name('login');          //Memproses halaman login
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout'); //Memproses halaman logout

Route::get('/auth/register', [AuthController::class, 'daftar'])->name('daftar');      //Menampilkan halaman register
Route::post('/auth/register', [AuthController::class, 'register'])->name('register'); //Memproses halaman register

Route::middleware(['checklogin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('pengaduan', PengaduanController::class);
    Route::resource('warga', WargaController::class);

    Route::middleware(['checkrole:admin'])->group(function () {
        Route::resource('tindak_lanjut', TindakLanjutController::class);
        Route::resource('penilaian', PenilaianLayananController::class);
        Route::resource('user', UserController::class);
        Route::resource('kategori', KategoriPengaduanController::class);

        Route::resource('warga', WargaController::class);

        Route::delete('/media/{id}', [TindakLanjutController::class, 'deleteMedia'])
            ->name('media.delete');
    });


});
