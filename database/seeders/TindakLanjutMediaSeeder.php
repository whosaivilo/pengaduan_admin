<?php
namespace Database\Seeders;

use App\Models\TindakLanjut;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TindakLanjutMediaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil file dari folder public/dummy
        $dummyPath   = public_path('dummy');
        $dummyImages = File::files($dummyPath);

        if (empty($dummyImages)) {
            $this->command->warn("Folder dummy kosong, tidak ada gambar untuk tindak lanjut.");
            return;
        }

        $tindakList = TindakLanjut::all();

        foreach ($tindakList as $tindak) {

            if (rand(1, 100) <= 50) { // 50% ada bukti foto tindak lanjut
                $randomFile = $dummyImages[array_rand($dummyImages)];
                $extension  = $randomFile->getExtension();
                $newName    = 'tindak/' . uniqid('tl_') . '.' . $extension;

                // Copy file ke storage/app/public/tindak/
                Storage::disk('public')->put(
                    $newName,
                    File::get($randomFile->getRealPath())
                );

                // Simpan path di tabel media lewat relasi
                $tindak->media()->create([
                    'path_file' => $newName,
                    'tipe_file' => 'tindak', // optional, bisa pakai tipe untuk membedakan jenis media
                ]);
            }
        }

        $this->command->info("Media bukti tindak lanjut berhasil ditambahkan ke tabel media.");
    }
}
