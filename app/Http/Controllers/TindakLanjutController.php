<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TindakLanjutController extends Controller
{
    public function index()
    {
        $tindakLanjut = TindakLanjut::with('pengaduan.media')->get();
        return view('pages.tindak_lanjut.index', compact('tindakLanjut'));
    }

    public function create()
    {
        $pengaduan = Pengaduan::where('status', '!=', 'Selesai')->get();
        return view('pages.tindak_lanjut.create', compact('pengaduan'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'pengaduan_id'   => 'required|exists:pengaduan,pengaduan_id',
            'petugas'        => 'required|string|max:100',
            'aksi'           => 'required|string',
            'catatan'        => 'nullable|string',
            'lampiran_bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // 2. SIMPAN TINDAK ANJUT UTAMA (Harus dilakukan terlebih dahulu dan selalu)
        $tindak = TindakLanjut::create([
            'pengaduan_id' => $validated['pengaduan_id'],
            'petugas'      => $validated['petugas'],
            'aksi'         => $validated['aksi'],
            'catatan'      => $validated['catatan'] ?? null,
        ]);

        // 3. UPLOAD DAN SIMPAN DATA MEDIA (Hanya jika ada file)
        // Baru simpan lampiran
        if ($request->hasFile('lampiran_bukti')) {
            $file = $request->file('lampiran_bukti');
            $path = $file->store('lampiran_tindak_lanjut', 'public');

            Media::create([
                'pengaduan_id' => $validated['pengaduan_id'], // cocok dg migration
                'path_file'    => 'storage/' . $path,
                'tipe_file'    => $file->getClientMimeType(),
            ]);
        }
        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil dicatat.');

    }

    public function destroy($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

      // Hapus media milik pengaduan yg sama
        $mediaRecords = Media::where('pengaduan_id', $tindakLanjut->pengaduan_id)->get();

        foreach ($mediaRecords as $media) {
            // Hapus file fisik
            $filePath = str_replace('storage/', 'public/', $media->path_file);
            Storage::delete($filePath);

            // Hapus dari database
            $media->delete();
        }

        // Hapus tindak lanjut
        $tindakLanjut->delete();

        return redirect()->route('tindak_lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dihapus.');
    }
}
