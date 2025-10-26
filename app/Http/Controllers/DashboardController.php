<?php

namespace App\Http\Controllers;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
          // 1. Ambil Data Statistik (untuk Card)
        $total_masuk       = Pengaduan::count();
        $belum_diproses    = Pengaduan::where('status', 'Baru')->count();
        $selesai_ditangani = Pengaduan::where('status', 'Selesai')->count();

        //Ambil 5 pengaduan terbaru untuk ditampilkan di dashboard
        $pengaduan_terbaru = Pengaduan::with('warga')->latest()->take(5)->get();

         // 3. Kirim semua data ke view
        return view('admin.index', compact('total_masuk', 'belum_diproses', 'selesai_ditangani', 'pengaduan_terbaru'));


    }
}
