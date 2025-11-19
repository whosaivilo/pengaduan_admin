<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PenilaianLayanan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik (untuk Card)
        $total_masuk       = Pengaduan::count();
        $belum_diproses    = Pengaduan::where('status', 'Baru')->count();
        $selesai_ditangani = Pengaduan::where('status', 'Selesai')->count();

        $rata_rata_rating = PenilaianLayanan::avg('rating'); // Menghitung rata-rata rating
        $total_penilaian  = PenilaianLayanan::count();

        //Ambil 5 pengaduan terbaru untuk ditampilkan di dashboard
        $pengaduan_terbaru = Pengaduan::with('warga')->latest()->take(5)->get();

        // 3. Kirim semua data ke view
        return view('pages.index', compact('total_masuk', 'belum_diproses', 'selesai_ditangani', 'rata_rata_rating',
            'total_penilaian', 'pengaduan_terbaru'));

    }
}
