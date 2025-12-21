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

        ],[
            'pengaduan_id.required'     => 'Pengaduan wajib dipilih.',
            'pengaduan_id.exists'       => 'Pengaduan tidak ditemukan.',
            'petugas.required'          => 'Nama petugas wajib diisi.',
            'petugas.string'            => 'Nama petugas harus berupa teks.',
            'petugas.max'               => 'Nama petugas maksimal 100 karakter.',
            'aksi.required'             => 'Aksi tindak lanjut wajib diisi.',
            'aksi.string'               => 'Aksi tindak lanjut harus berupa teks.',
            'catatan.string'            => 'Catatan harus berupa teks.',
            'lampiran_bukti.required'   => 'Minimal unggah 1 lampiran.',
            'lampiran_bukti.array'      => 'Lampiran harus berupa array file.',
            'lampiran_bukti.*.file'     => 'Lampiran harus berupa file.',
            'lampiran_bukti.*.mimes'    => 'Format lampiran harus JPG atau PNG.',
            'lampiran_bukti.*.max'      => 'Ukuran lampiran maksimal 4 MB.',
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
                // Simpan metadata ke tabel media
                Media::create([
                    'ref_table'  => 'tindak_lanjut',    // wajib manual
                    'ref_id'     => $tindak->tindak_id, // wajib manual
                    'file_name'  => $filename,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sort++,
                    'caption'    => null,
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
            'lampiran_bukti.*' => 'file|mimes:jpeg,jpg,png|max:4096',

        ], [
            'petugas.required'       => 'Nama petugas wajib diisi.',
            'petugas.string'         => 'Nama petugas harus berupa teks.',
            'petugas.max'            => 'Nama petugas maksimal 100 karakter.',
            'aksi.required'          => 'Aksi tindak lanjut wajib diisi.',
            'aksi.string'            => 'Aksi tindak lanjut harus berupa teks.',
            'catatan.string'         => 'Catatan harus berupa teks.',
            'lampiran_bukti.min'     => 'Minimal unggah 1 lampiran.',
            'lampiran_bukti.*.file'  => 'Lampiran harus berupa file.',
            'lampiran_bukti.*.mimes' => 'Format lampiran harus JPG atau PNG.',
            'lampiran_bukti.*.max'   => 'Ukuran lampiran maksimal 4 MB.',

        ]);

        // 2. Temukan Tindak Lanjut berdasarkan ID
        $tindakLanjut = TindakLanjut::findOrFail($id);

        // 3. Update data Tindak Lanjut
        $tindakLanjut->petugas = $validated['petugas'];
        $tindakLanjut->aksi    = $validated['aksi'];
        $tindakLanjut->catatan = $validated['catatan'] ?? null;

        // 4. Cek apakah ada lampiran baru yang diunggah
        if ($request->hasFile('lampiran_bukti')) {

            $files = $request->file('lampiran_bukti');
            $files = is_array($files) ? $files : [$files];

            $sort = $tindakLanjut->media()->count() + 1;

            foreach ($files as $file) {

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('tindak', $filename, 'public');

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
