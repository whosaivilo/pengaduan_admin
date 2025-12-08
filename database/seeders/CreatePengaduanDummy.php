<?php
namespace Database\Seeders;

use App\Models\KategoriPengaduan;
use App\Models\Warga;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Wajib import untuk ambil ID Warga
use Illuminate\Support\Str;

// Wajib import untuk ambil ID Kategori

class CreatePengaduanDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker      = Factory::create('id_ID'); // Menggunakan lokal Indonesia
        $jumlahData = 100;


        // Ambil semua ID warga dan kategori yang sudah ada
        $wargaIds    = Warga::pluck('warga_id')->toArray();
        $kategoriAll = KategoriPengaduan::all();

        // Pengecekan data master: Penting agar FK tidak gagal
        if (empty($wargaIds) || empty($kategoriAll)) {
            $this->command->warn('Tidak dapat membuat Pengaduan: Warga atau Kategori belum ada di database. Jalankan WargaSeeder dan KategoriPengaduanSeeder terlebih dahulu.');
            return;
        }
        // Template berdasarkan kategori
        $template = [
            'Infrastruktur Rusak Berat'      => [
                'judul'     => [
                    'Jalan Utama Berlubang Parah',
                    'Tembok Penahan Longsor Rusak',
                    'Aspal Jalan Retak dan Ambles',
                ],
                'deskripsi' => [
                    'Warga melaporkan kerusakan parah pada infrastruktur di wilayah tersebut.',
                    'Kondisi jalan sudah tidak layak dilalui dan membahayakan pengguna.',
                    'Kerusakan telah terjadi selama beberapa minggu tanpa perbaikan.',
                ],
            ],

            'Layanan Administrasi'           => [
                'judul'     => [
                    'Pengajuan KK Tidak Diproses',
                    'Keterlambatan Penerbitan Surat Domisili',
                ],
                'deskripsi' => [
                    'Pemohon mengalami keterlambatan layanan administrasi.',
                    'Proses layanan memakan waktu lebih lama dari standar SLA.',
                ],
            ],

            'Kebersihan (Sampah Menumpuk)'   => [
                'judul'     => [
                    'Sampah Menumpuk di TPS RT 02',
                    'Tidak Ada Petugas Pengangkutan Sampah',
                ],
                'deskripsi' => [
                    'Sampah tidak diangkut selama lebih dari 3 hari.',
                    'Aroma tidak sedap mulai mengganggu warga sekitar.',
                ],
            ],

            'Fasilitas Umum (Non-Prioritas)' => [
                'judul'     => [
                    'Bangku Taman Rusak',
                    'Cat Shelter Bus Mengelupas',
                ],
                'deskripsi' => [
                    'Fasilitas umum mengalami kerusakan ringan.',
                    'Warga berharap fasilitas dapat diperbaiki untuk kenyamanan.',
                ],
            ],

            'Keamanan dan Ketertiban'        => [
                'judul'     => [
                    'Keributan Malam Hari di RT 04',
                    'Pencurian Motor di Area Parkir',
                ],
                'deskripsi' => [
                    'Warga melaporkan aktivitas yang mengganggu ketertiban.',
                    'Kejadian membuat warga merasa tidak aman.',
                ],
            ],

            'Aspirasi dan Masukan'           => [
                'judul'     => [
                    'Usulan Adanya Posyandu Baru',
                    'Permintaan Penambahan Tempat Sampah',
                ],
                'deskripsi' => [
                    'Warga memberikan masukan untuk meningkatkan fasilitas umum.',
                    'Usulan dianggap dapat meningkatkan kenyamanan lingkungan.',
                ],
            ],

            'Kerusakan Lampu Jalan/PJU'      => [
                'judul'     => [
                    'Lampu Jalan Padam di Blok C',
                    'PJU Mati Selama 3 Hari',
                ],
                'deskripsi' => [
                    'Lampu jalan padam sehingga area menjadi gelap.',
                    'Kondisi berpotensi menyebabkan kecelakaan atau tindakan kriminal.',
                ],
            ],
        ];

        foreach (range(1, $jumlahData) as $index) {

            $kategori     = $kategoriAll->random(); // entire row
            $namaKategori = $kategori->nama;

            DB::table('pengaduan')->insert([
                'nomor_tiket'    => 'PND' . now()->format('dHi') . Str::random(5),
                'warga_id'       => $faker->randomElement($wargaIds),
                'kategori_id'    => $kategori->kategori_id,

                // ambil random template sesuai kategori
                'judul'          => $faker->randomElement($template[$namaKategori]['judul']),
                'deskripsi'      => $faker->randomElement($template[$namaKategori]['deskripsi']),

                'status'         => $faker->randomElement(['Diproses', 'Selesai']),
                'lokasi_text'    => $faker->address,
                'rt'             => $faker->numberBetween(1, 10),
                'rw'             => $faker->numberBetween(1, 10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

        }
    }
}
