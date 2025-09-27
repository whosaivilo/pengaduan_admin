<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;




Route::get('/', function () {
    return view('welcome');
});
Route::get('/contoh', function(){
    return "Contoh";
});

Route::get('/pengaduan', [PengaduanController::class, 'index']);
