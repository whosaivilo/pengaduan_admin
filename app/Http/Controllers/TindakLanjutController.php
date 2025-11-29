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
    public function index(Request $request)
    {
        $filterableColumns = ['petugas'];
        $searchableColumns = ['aksi', 'catatan'];
        $tindakLanjut      = TindakLanjut::with('pengaduan.media')
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString()
            ->onEachSide(1);
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
            'pengaduan_id'     => 'required|exists:pengaduan,pengaduan_id',
            'petugas'          => 'required|string|max:100',
            'aksi'             => 'required|string',
            'catatan'          => 'nullable|string',
            'lampiran_bukti'   => 'required|array',
            'lampiran_bukti.*' => 'file|mimes:jpeg,jpg,png|max:4096',

        ]);

        // 2. SIMPAN TINDAK ANJUT UTAMA (Harus dilakukan terlebih dahulu dan selalu)
        $tindak = TindakLanjut::create([
            'pengaduan_id' => $validated['pengaduan_id'],
            'petugas'      => $validated['petugas'],
            'aksi'         => $validated['aksi'],
            'catatan'      => $validated['catatan'] ?? null,
        ]);

        // UPLOAD MULTIPLE FILES
        if ($request->hasFile('lampiran_bukti')) {

            $sort = 1;

            foreach ($request->file('lampiran_bukti') as $file) {

                $filename = time() . '_' . $file->getClientOriginalName();
                $path     = $file->storeAs('tindak', $filename, 'public');

                // Simpan metadata media
                $tindak->media()->create([
                    'ref_table'  => 'tindak_lanjut',    // TAMBAHKAN INI
                    'ref_id'     => $tindak->tindak_id, // Walaupun sudah otomatis dari relasi, ini untuk kejelasan
                    'file_name'  => $filename,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sort++,
                    'caption'    => null, // Bisa diisi dari form jika ada
                ]);
            }
        }
        // UPDATE STATUS PENGADUAN
        $pengaduan         = Pengaduan::find($request->pengaduan_id);
        $pengaduan->status = 'Selesai';
        $pengaduan->save();

        return redirect()->route('tindak_lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dicatat.');
    }

    public function edit($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);
        $pengaduan    = Pengaduan::where('status', '!=', 'Selesai')->get();

        return view('pages.tindak_lanjut.edit', compact('tindakLanjut', 'pengaduan'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi
        $validated = $request->validate([
            'petugas'          => 'required|string|max:100',
            'aksi'             => 'required|string',
            'catatan'          => 'nullable|string',
            'lampiran_bukti'   => 'nullable|array',
            'lampiran_bukti.*' => 'file|mimes:jpeg,jpg,png|max:2048',
        ]);

        // 2. Temukan Tindak Lanjut berdasarkan ID
        $tindakLanjut = TindakLanjut::findOrFail($id);

        // 3. Update data Tindak Lanjut
        $tindakLanjut->petugas = $validated['petugas'];
        $tindakLanjut->aksi    = $validated['aksi'];
        $tindakLanjut->catatan = $validated['catatan'] ?? null;

        // 4. Cek apakah ada lampiran baru yang diunggah
        if ($request->hasFile('lampiran_bukti')) {
            $sort = $tindakLanjut->media()->count() + 1;
            foreach ($request->file('lampiran_bukti') as $file) {

                $filename = time() . '_' . $file->getClientOriginalName();
                $path     = $file->storeAs('tindak', $filename, 'public');

                $tindakLanjut->media()->create([
                    'ref_table'  => 'tindak_lanjut',
                    'ref_id'     => $tindakLanjut->tindak_id,
                    'file_name'  => $filename,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sort++,
                ]);
            }
        }

        // 5. Simpan perubahan
        $tindakLanjut->save();

        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil diperbarui.');
    }

    public function show($id)
    {
        $tindak = TindakLanjut::with(['pengaduan', 'media'])->findOrFail($id);

        return view('pages.tindak_lanjut.show', compact('tindak'));
    }
    public function destroy($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

        // Hapus semua file fisik dari storage dan record dari tabel media
        $tindakLanjut->media->each(function (Media $media) {
            // Hapus file fisik (folder 'tindak')
            Storage::disk('public')->delete('tindak/' . $media->file_name);
            // Hapus record dari DB
            $media->delete();
        });

        // Hapus tindak lanjut
        $tindakLanjut->delete();

        return redirect()->route('tindak_lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dihapus.');
    }
    public function deleteMedia($id)
{
    $media = Media::findOrFail($id);

    // Hapus file fisik
    Storage::disk('public')->delete('tindak/' . $media->file_name);

    // Hapus record
    $media->delete();

    return back()->with('success', 'Lampiran berhasil dihapus.');
}
}
