<?php
namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Str;

class CreateTindakLanjut extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $pengaduanList = Pengaduan::all();

        if ($pengaduanList->isEmpty()) {
            $this->command->warn('Tidak ada data pengaduan! Jalankan PengaduanSeeder dulu.');
            return;
        }

        // Mapping aksi dan catatan realistis berdasarkan kategori
        $aksiByKategori = [
            'Infrastruktur Rusak Berat' => [
                ['aksi' => "Survey lokasi dilakukan", 'catatan' => ["Survey selesai, menunggu laporan", "Kondisi jalan diperiksa petugas"]],
                ['aksi' => "Koordinasi dengan Dinas PU", 'catatan' => ["Sudah dikirim ke Dinas PU", "Menunggu konfirmasi jadwal perbaikan"]],
                ['aksi' => "Perbaikan dijadwalkan", 'catatan' => ["Perbaikan dijadwalkan minggu depan", "Petugas PU sudah siap untuk eksekusi"]],
            ],
            'Layanan Administrasi' => [
                ['aksi' => "Berkas divalidasi", 'catatan' => ["Data pemohon dicek kelengkapannya", "Validasi selesai, siap diproses"]],
                ['aksi' => "Pengajuan diproses", 'catatan' => ["Pengajuan sedang diproses admin", "Estimasi selesai 2 hari kerja"]],
                ['aksi' => "Dokumen diterbitkan", 'catatan' => ["Dokumen sudah diterbitkan", "Pemohon bisa mengambil di kantor RW"]],
            ],
            'Kebersihan (Sampah Menumpuk)' => [
                ['aksi' => "Petugas kebersihan diterjunkan", 'catatan' => ["Petugas sedang melakukan pengangkutan", "Jumlah sampah menurun setelah kegiatan"]],
                ['aksi' => "Lokasi dibersihkan", 'catatan' => ["TPS bersih setelah aksi", "Warga mengapresiasi kebersihan"]],
                ['aksi' => "Monitoring kebersihan", 'catatan' => ["Petugas memantau rutin setiap hari", "Lokasi tetap bersih selama 3 hari terakhir"]],
            ],
            'Fasilitas Umum (Non-Prioritas)' => [
                ['aksi' => "Pemeriksaan fasilitas dilakukan", 'catatan' => ["Fasilitas masih layak pakai", "Ditemukan kerusakan minor"]],
                ['aksi' => "Pengajuan pemeliharaan", 'catatan' => ["Pengajuan masuk ke RT/RW", "Menunggu persetujuan anggaran"]],
                ['aksi' => "Dijadwalkan untuk perbaikan ringan", 'catatan' => ["Perbaikan dijadwalkan minggu depan", "Petugas pemeliharaan siap"]],
            ],
            'Keamanan dan Ketertiban' => [
                ['aksi' => "Petugas linmas dikerahkan", 'catatan' => ["Petugas patroli malam", "Warga merasa lebih aman"]],
                ['aksi' => "Dilakukan patroli lokasi", 'catatan' => ["Patroli rutin setiap hari", "Kondisi lingkungan terkendali"]],
                ['aksi' => "Koordinasi dengan pihak terkait", 'catatan' => ["Koordinasi selesai, tindakan dilanjutkan", "Pihak terkait sudah menindaklanjuti"]],
            ],
            'Aspirasi dan Masukan' => [
                ['aksi' => "Aspirasi dicatat", 'catatan' => ["Usulan dicatat di agenda RW", "Warga diminta menunggu tindak lanjut"]],
                ['aksi' => "Dibahas dalam rapat RW", 'catatan' => ["Rapat dilakukan, usulan diterima", "Prioritas diberikan sesuai urgensi"]],
                ['aksi' => "Dijadikan masukan program", 'catatan' => ["Masukan masuk dalam program kerja bulan depan", "Tim menyiapkan evaluasi lanjutan"]],
            ],
            'Kerusakan Lampu Jalan/PJU' => [
                ['aksi' => "PJU dicek", 'catatan' => ["Lampu diperiksa teknisi", "Ditemukan kerusakan pada panel"]],
                ['aksi' => "Kerusakan ditemukan", 'catatan' => ["Kerusakan dilaporkan ke Dinas PU", "Estimasi perbaikan 3 hari"]],
                ['aksi' => "Penggantian lampu dijadwalkan", 'catatan' => ["Lampu diganti minggu depan", "Petugas PU sudah menyiapkan lampu cadangan"]],
            ],
        ];

        $petugasList = [
            "Admin Sistem",
            "Petugas Lapangan",
            "Petugas Kebersihan",
            "Satpam Lingkungan",
            "Operator RW",
            "Dinas Terkait",
        ];

         $jumlahData = 100; // target 100 data TindakLanjut

        for ($i = 0; $i < $jumlahData; $i++) {

            $pengaduan = $faker->randomElement($pengaduanList);
            $kategoriNama = $pengaduan->kategori->nama ?? null;

            if (!$kategoriNama || !isset($aksiByKategori[$kategoriNama])) {
                $i--; // ulangi loop agar tetap dapat 100 data valid
                continue;
            }

            $aksiData = $faker->randomElement($aksiByKategori[$kategoriNama]);
            $aksi = $aksiData['aksi'];

            $catatan = rand(0, 1) === 1 ? $faker->randomElement($aksiData['catatan']) : null;


            TindakLanjut::create([
                'pengaduan_id'   => $pengaduan->pengaduan_id,
                'petugas'        => $faker->randomElement($petugasList),
                'aksi'           => $aksi,
                'catatan'        => $catatan,

            ]);
        }
    }
}
