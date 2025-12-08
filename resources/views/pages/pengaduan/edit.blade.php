@extends('layouts.app')

@section('title_page', 'Edit Gambar Pengaduan')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-white rounded p-4">

        <h4 class="mb-4">Edit Gambar Pengaduan</h4>

        {{-- INFORMASI PENGADUAN (READONLY) --}}
        <div class="mb-4 p-3 bg-dark rounded">
            <h6>Informasi Pengaduan (Tidak Bisa Diedit)</h6>
            <div class="row text-start mt-3">

                <div class="col-md-4">
                    <label class="form-label">Nomor Tiket</label>
                    <input type="text" class="form-control" value="{{ $pengaduan->nomor_tiket }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Warga</label>
                    <input type="text" class="form-control" value="{{ $pengaduan->warga->nama }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <input type="text" class="form-control" value="{{ $pengaduan->kategori->nama }}" readonly>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" value="{{ $pengaduan->judul }}" readonly>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" rows="3" readonly>{{ $pengaduan->deskripsi }}</textarea>
                </div>
            </div>
        </div>

        {{-- BAGIAN GAMBAR LAMA --}}
        <div class="mb-4">
            <h6>Gambar Saat Ini</h6>

            @if ($pengaduan->media->count() == 0)
                <p class="text-warning">Belum ada gambar di pengaduan ini.</p>
            @endif

            <div class="row">
                @foreach ($pengaduan->media as $media)
                    <div class="col-md-3 mb-3 text-center">
                        <div class="bg-dark p-2 rounded">
                            <img src="{{ asset('storage/pengaduan/' . $media->file_name) }}"
                                 class="img-fluid rounded mb-2"
                                 style="max-height: 160px; object-fit: cover;">

                            {{-- Tombol Hapus Gambar --}}
                            <form action="{{ route('pengaduan.media.delete', $media->media_id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FORM UPLOAD GAMBAR BARU --}}
        <div class="mb-4">
            <h6>Tambah Gambar Baru</h6>

            <form action="{{ route('pengaduan.update', $pengaduan->pengaduan_id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Upload Gambar (bisa lebih dari satu)</label>
                    <input type="file"
                           name="lampiran_bukti[]"
                           class="form-control bg-dark text-white"
                           multiple>
                    <small class="text-info">Format: JPG/PNG, max 2MB per gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('pengaduan.show', $pengaduan->pengaduan_id) }}" class="btn btn-light mt-2">
                    Kembali
                </a>
            </form>
        </div>

    </div>
</div>
@endsection
