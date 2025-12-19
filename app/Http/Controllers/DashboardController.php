<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PenilaianLayanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('auth')->with('error', 'Silakan Login dulu');
        }

        // =====================
        // KARTU STATISTIK
        // =====================
        $total_masuk       = Pengaduan::count();
        $belum_diproses    = Pengaduan::where('status', 'Diproses')->count();
        $selesai_ditangani = Pengaduan::where('status', 'Selesai')->count();

        $rata_rata_rating = PenilaianLayanan::avg('rating');
        $total_penilaian  = PenilaianLayanan::count();

        $pengaduan_terbaru = Pengaduan::with('warga')->latest()->take(5)->get();

        // =====================
        // CHART STATUS
        // =====================
        $chartStatus = [
            'Diproses' => $belum_diproses,
            'Selesai'  => $selesai_ditangani,
        ];

        $totalPengaduan = $belum_diproses + $selesai_ditangani;

        $persenSelesai = $totalPengaduan > 0
            ? round(($selesai_ditangani / $totalPengaduan) * 100)
            : 0;

        if ($persenSelesai >= 80) {
            $insightText  = 'Sebagian besar pengaduan telah berhasil diselesaikan. Kinerja penanganan tergolong sangat baik.';
            $insightClass = 'text-success';
        } elseif ($persenSelesai >= 50) {
            $insightText  = 'Sebagian pengaduan telah diselesaikan, namun masih terdapat laporan yang perlu perhatian lebih.';
            $insightClass = 'text-warning';
        } else {
            $insightText  = 'Mayoritas pengaduan masih dalam proses. Diperlukan peningkatan kecepatan penanganan.';
            $insightClass = 'text-danger';
        }
        // =====================
// CHART PERSEBARAN WILAYAH (RT/RW)
// =====================
        $wilayahPengaduan = Pengaduan::select(
            DB::raw("CONCAT('RT ', rt, ' / RW ', rw) as wilayah"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('rt', 'rw')
            ->orderByDesc('total')
            ->limit(5) // ambil 5 wilayah teratas biar rapi
            ->get();

        $labelWilayah = $wilayahPengaduan->pluck('wilayah');
        $dataWilayah  = $wilayahPengaduan->pluck('total');

        return view('pages.index', compact(
            'total_masuk',
            'belum_diproses',
            'selesai_ditangani',
            'rata_rata_rating',
            'total_penilaian',
            'pengaduan_terbaru',
            'chartStatus',
            'persenSelesai',
            'insightText',
            'insightClass',
            'labelWilayah',
            'dataWilayah',

        ));
    }
}
