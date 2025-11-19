<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\PenilaianLayanan;
use Faker\Factory;

class PenilaianLayananSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Ambil pengaduan selesai tanpa penilaian
        $pengaduanList = Pengaduan::where('status', 'Selesai')
            ->whereDoesntHave('penilaianLayanan')
            ->get();

        if ($pengaduanList->isEmpty()) {
            $this->command->warn('Tidak ada pengaduan selesai yang bisa dinilai!');
            return;
        }

        // Template komentar berdasarkan kategori
        $komentarByKategori = [
            'Infrastruktur Rusak Berat' => [
                "Perbaikan jalan berjalan lancar",
                "Pekerjaan belum selesai sepenuhnya",
                "Petugas bekerja sesuai jadwal"
            ],
            'Layanan Administrasi' => [
                "Proses cepat dan jelas",
                "Masih ada dokumen yang kurang",
                "Pelayanan ramah dan profesional"
            ],
            'Kebersihan (Sampah Menumpuk)' => [
                "Area bersih setelah pengangkutan",
                "Sampah masih menumpuk beberapa titik",
                "Petugas bertanggung jawab"
            ],
            'Fasilitas Umum (Non-Prioritas)' => [
                "Pemeliharaan memadai",
                "Masih ada fasilitas yang rusak ringan",
                "Perbaikan dilakukan tepat waktu"
            ],
            'Keamanan dan Ketertiban' => [
                "Lingkungan lebih aman",
                "Patroli kurang rutin",
                "Petugas sigap dalam menangani gangguan"
            ],
            'Aspirasi dan Masukan' => [
                "Usulan ditindaklanjuti",
                "Masih menunggu keputusan RW",
                "Masukan warga diperhatikan"
            ],
            'Kerusakan Lampu Jalan/PJU' => [
                "Lampu jalan menyala normal",
                "Beberapa lampu masih mati",
                "Perbaikan lampu dijadwalkan"
            ],
        ];

        $count = 0;
        $jumlahData = 100;

        while ($count < $jumlahData) {
            $pengaduan = $faker->randomElement($pengaduanList);

            // Pastikan pengaduan belum punya penilaian
            if (PenilaianLayanan::where('pengaduan_id', $pengaduan->pengaduan_id)->exists()) {
                continue;
            }

            $kategoriNama = $pengaduan->kategori->nama ?? null;
            $komentar = $kategoriNama && isset($komentarByKategori[$kategoriNama])
                        ? $faker->randomElement($komentarByKategori[$kategoriNama])
                        : $faker->sentence(8);

            PenilaianLayanan::create([
                'pengaduan_id' => $pengaduan->pengaduan_id,
                'rating'       => rand(1, 5),
                'komentar'     => rand(0, 1) === 1 ? $komentar : null,
            ]);

            $count++;
        }
    }
}
