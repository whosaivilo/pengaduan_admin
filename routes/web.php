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

    // Dashboard → boleh diakses semua user yg login
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROUTE KHUSUS ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:admin'])->group(function () {

        Route::resource('user', UserController::class);
        Route::resource('pengaduan', PengaduanController::class);
        Route::resource('kategori', KategoriPengaduanController::class);
        Route::resource('penilaian', PenilaianLayananController::class);
        Route::resource('tindak_lanjut', TindakLanjutController::class);
        Route::resource('warga', WargaController::class);

        Route::delete('/media/{id}', [TindakLanjutController::class, 'deleteMedia'])
            ->name('media.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | ROUTE KHUSUS USER BIASA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:user'])->group(function () {

        Route::resource('pengaduan', PengaduanController::class);
        Route::resource('warga', WargaController::class);

    });

});
