@extends('layouts.app')
@section('title_page', 'Detail Pengaduan')
@section('content')

    @php
        // Pastikan Anda mendapatkan $pengaduan dari Controller@show
        if (isset($pengaduan->kategori_id)) {
            $kategoriNama = match ((int) $pengaduan->kategori_id) {
                1 => 'Infrastruktur',
                2 => 'Pelayanan Publik',
                3 => 'Keamanan & Ketertiban',
                default => 'ID Tidak Dikenal',
            };
        } else {
            $kategoriNama = 'N/A';
        }
    @endphp

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-10">

                {{-- KARTU DETAIL PENGADUAN --}}
                <div class="bg-secondary rounded p-4 mb-4">
                    <h5 class="mb-3 text-primary">Detail Pengaduan #{{ $pengaduan->nomor_tiket }}</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
                            <p><strong>Pelapor:</strong> {{ $pengaduan->warga->nama ?? 'N/A' }}</p>
                            <p><strong>Lokasi (RT/RW):</strong> {{ $pengaduan->lokasi_text }} (RT
                                {{ $pengaduan->rt }}/RW {{ $pengaduan->rw }})</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Tanggal Diajukan:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}
                            </p>
                            <p><strong>Kategori:</strong> {{ $kategoriNama }}

                            </p>
                            <p><strong>Status:</strong>
                                @php
                                    $badgeClass = match ($pengaduan->status) {
                                        'Baru' => 'bg-danger',
                                        'Diproses' => 'bg-warning',
                                        'Selesai' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $pengaduan->status }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="text-white-50">

                    {{-- DESKRIPSI (Textarea non-editable) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                        <textarea class="form-control bg-dark text-white" rows="4" readonly>{{ $pengaduan->deskripsi }}</textarea>
                    </div>

                    {{-- FOTO BUKTI --}}
                    @if ($pengaduan->lampiran_bukti)
                        <div class="mb-3">
                            <label class="form-label">Lampiran Bukti</label><br>
                            <img src="{{ asset($pengaduan->lampiran_bukti) }}" alt="Foto Bukti"
                                style="max-width: 400px; height: auto; border-radius: 8px;">
                            <p class="form-text mt-2 text-white-50">Path: {{ $pengaduan->lampiran_bukti }}</p>
                        </div>
                    @endif

                </div>


                {{-- KARTU TINDAK LANJUT (Hanya Tampil Jika Status Belum Selesai) --}}
                @if ($pengaduan->status == 'Baru' || $pengaduan->status == 'Diproses')
                    <div class="bg-secondary rounded p-4">
                        <h6 class="mb-4 text-warning">Tindak Lanjut / Perubahan Status</h6>

                        {{-- Form Tindak Lanjut (Asumsi kita update status dan catatan ke PengaduanController@update) --}}
                        <form action="{{ route('pengaduan.update', $pengaduan->pengaduan_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="catatan_tindak_lanjut" class="form-label">Catatan Tindak Lanjut
                                    Petugas</label>
                                <textarea class="form-control" name="catatan_tindak_lanjut" rows="3"
                                    placeholder="Masukkan detail tindakan yang sudah dilakukan...">{{ old('catatan_tindak_lanjut') }}</textarea>
                                {{-- Anda perlu menambahkan kolom 'catatan_tindak_lanjut' di tabel pengaduan/tindak_lanjut --}}
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_baru" class="form-label">Ubah Status Menjadi:</label>
                                    <select class="form-select" name="status" id="status_baru" required>
                                        <option value="">-- Pilih Status Baru --</option>
                                        {{-- Opsi disesuaikan dengan status saat ini --}}
                                        <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>
                                            Diproses
                                        </option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 align-self-end">
                                    <button type="submit" class="btn btn-warning w-100">Simpan Tindak Lanjut &
                                        Ubah Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-success rounded p-4 text-white">
                        <p class="mb-0">✅ Pengaduan ini sudah **Selesai Ditangani**.</p>
                    </div>
                @endif

                <div class="mt-4 text-end">
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>

            </div>
        </div>
    </div>
@endsection
