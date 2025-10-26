<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KategoriPengaduanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', [AuthController::class, 'index'])->name('auth'); //Halaman login
Route::post('/auth', [AuthController::class, 'login'])->name('login'); //Memproses halaman login

Route::get('/auth/register', [AuthController::class, 'daftar'])->name('daftar'); //Menampilkan halaman register
Route::post('/auth/register', [AuthController::class, 'register'])->name('register'); //Memproses halaman register

// 1. DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 2. PENGADUAN (CRUD Data)
// Gunakan resource tanpa pengecualian (except) karena index() sudah kita perbaiki
Route::resource('pengaduan', PengaduanController::class);


// 3. WARGA (Data Master)
Route::resource('warga', WargaController::class);

// 4. User (Data Master)
Route::resource('user', UserController::class);

Route::resource('kategori', KategoriPengaduanController::class);
