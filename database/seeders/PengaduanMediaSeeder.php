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
                $filename   = uniqid('lamp_') . '.' . $extension;

                // simpan ke storage/app/public/lampiran_pengaduan
                Storage::disk('public')->put(
                    'lampiran_pengaduan/' . $filename,
                    File::get($randomFile->getRealPath())
                );

                // simpan ke TABEL MEDIA
                $p->media()->create([
                    'path_file' => 'lampiran_pengaduan/' . $filename,
                    'tipe_file' => 'pengaduan',
                ]);

                // UPDATE KOLOM TABEL PENGADUAN
                $p->update([
                    'lampiran_bukti' => $filename,
                ]);
            }
        }

        $this->command->info("Media bukti pengaduan berhasil ditambahkan ke tabel media dan kolom lampiran_bukti.");
    }
}
