<?php
namespace Database\Seeders;

use App\Models\Pengaduan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PengaduanMediaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil file dari folder public/dummy
        $dummyPath   = public_path('dummy');
        $dummyImages = File::files($dummyPath);

        if (empty($dummyImages)) {
            $this->command->warn("Folder dummy kosong, tidak ada gambar untuk pengaduan.");
            return;
        }

        $pengaduans = Pengaduan::all();

       foreach ($pengaduans as $p) {

    if (rand(1, 100) <= 60) {
        $randomFile = $dummyImages[array_rand($dummyImages)];
        $extension  = $randomFile->getExtension();
        $newName    = 'lampiran_pengaduan/' . uniqid('lamp_') . '.' . $extension;

        Storage::put('public/' . $newName, File::get($randomFile->getRealPath()));

        // Simpan ke kolom lampiran_bukti (agar view bisa langsung pakai)
        $p->update(['lampiran_bukti' => $newName]);

        // Optional: Simpan juga ke tabel media
        $p->media()->create([
            'path_file' => $newName,
            'tipe_file' => 'pengaduan',
        ]);
    }
}
        $this->command->info("Media bukti pengaduan berhasil ditambahkan ke tabel media dan kolom lampiran_bukti.");
    }
}
