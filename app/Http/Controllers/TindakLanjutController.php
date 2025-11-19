<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'pengaduan_id'   => 'required|exists:pengaduan,pengaduan_id',
            'petugas'        => 'required|string|max:100',
            'aksi'           => 'required|string',
            'catatan'        => 'nullable|string',
            'lampiran_bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('lampiran_bukti')) {
            $file                        = $request->file('lampiran_bukti');
            $filename                    = time() . '_' . $file->getClientOriginalName();
            $path                        = $file->storeAs('tindak', $filename, 'public');
            $validated['lampiran_bukti'] = $path;
        }

        // 2. SIMPAN TINDAK ANJUT UTAMA (Harus dilakukan terlebih dahulu dan selalu)
        $tindak = TindakLanjut::create([
            'pengaduan_id'   => $validated['pengaduan_id'],
            'petugas'        => $validated['petugas'],
            'aksi'           => $validated['aksi'],
            'catatan'        => $validated['catatan'] ?? null,
            'lampiran_bukti' => $validated['lampiran_bukti'] ?? null,
        ]);

        // 1. Cari objek Pengaduan yang ditindaklanjuti
        $pengaduan = Pengaduan::findOrFail($request->pengaduan_id);

        // 2. Update status menjadi 'selesai'
        $pengaduan->status = 'selesai';
        $pengaduan->save();

        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil dicatat dan Status Pengaduan diperbarui menjadi Selesai.');

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
            'petugas'        => 'required|string|max:100',
            'aksi'           => 'required|string',
            'catatan'        => 'nullable|string',
            'lampiran_bukti' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // 2. Temukan Tindak Lanjut berdasarkan ID
        $tindakLanjut = TindakLanjut::findOrFail($id);

        // 3. Update data Tindak Lanjut
        $tindakLanjut->petugas = $validated['petugas'];
        $tindakLanjut->aksi    = $validated['aksi'];
        $tindakLanjut->catatan = $validated['catatan'] ?? null;

        // 4. Cek apakah ada lampiran baru yang diunggah
        if ($request->hasFile('lampiran_bukti')) {
            // Hapus file lama jika ada
            if ($tindakLanjut->lampiran_bukti) {
                Storage::disk('public')->delete($tindakLanjut->lampiran_bukti);
            }
            $file                         = $request->file('lampiran_bukti');
            $filename                     = time() . '_' . $file->getClientOriginalName();
            $path                         = $file->storeAs('tindak', $filename, 'public');
            $tindakLanjut->lampiran_bukti = $path;
        }

        // 5. Simpan perubahan
        $tindakLanjut->save();

        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

        // Hapus tindak lanjut
        $tindakLanjut->delete();

        return redirect()->route('tindak_lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dihapus.');
    }
}
