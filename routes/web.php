<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;

Route::get('/dashboard', [PengaduanController::class, 'index'])->name('dashboard');
Route::resource('pengaduan', PengaduanController::class)->except(['index','edit','update']);
Route::get('/pengaduan', [PengaduanController::class, 'lihat'])->name('pengaduan.index');


Route::resource('warga', WargaController::class);
Route::put('/pengaduan/{pengaduan_id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.status');

Route::put('/pengaduan/status/{pengaduan_id}', [PengaduanController::class, 'update'])->name('pengaduan.update.status');
