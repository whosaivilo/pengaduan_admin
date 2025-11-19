<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CreateKategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            // Kategori 1: Prioritas Tinggi, SLA cepat
            [
                'nama'      => 'Infrastruktur Rusak Berat',
                'sla_hari'  => 3,
                'prioritas' => 'Tinggi',
            ],
            // Kategori 2: Prioritas Sedang, SLA standar
            [
                'nama'      => 'Layanan Administrasi',
                'sla_hari'  => 7,
                'prioritas' => 'Sedang',
            ],
            // Kategori 3: Prioritas Tinggi, SLA sangat cepat (darurat)
            [
                'nama'      => 'Kebersihan (Sampah Menumpuk)',
                'sla_hari'  => 1,
                'prioritas' => 'Tinggi',
            ],
            // Kategori 4: Prioritas Rendah, SLA lama
            [
                'nama'      => 'Fasilitas Umum (Non-Prioritas)',
                'sla_hari'  => 14,
                'prioritas' => 'Rendah',
            ],
            // Kategori 5: Prioritas Sedang
            [
                'nama'      => 'Keamanan dan Ketertiban',
                'sla_hari'  => 5,
                'prioritas' => 'Sedang',
            ],
            // Kategori 6: Prioritas Rendah
            [
                'nama'      => 'Aspirasi dan Masukan',
                'sla_hari'  => 30,
                'prioritas' => 'Rendah',
            ],
            // Kategori 7: Prioritas Tinggi
            [
                'nama'      => 'Kerusakan Lampu Jalan/PJU',
                'sla_hari'  => 4,
                'prioritas' => 'Tinggi',
            ],
        ];

        DB::table('kategori_pengaduan')->insert($kategori);
    }
}
