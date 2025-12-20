@extends('layouts.app')

@section('title_page', 'Edit Pengaduan')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-white rounded p-4">

            <h4 class="mb-4">Edit Pengaduan</h4>

            <form action="{{ route('pengaduan.update', $pengaduan->pengaduan_id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFORMASI STATIS --}}
                <div class="mb-4 p-3 bg-dark rounded">
                    <h6>Informasi Pengaduan</h6>

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
                    </div>
                </div>

                {{-- JUDUL --}}
                <div class="mb-3 text-start">
                    <label class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengaduan->judul) }}">
                    @error('judul')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3 text-start">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- LOKASI --}}
                <div class="mb-3 text-start">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi_text" class="form-control"
                        value="{{ old('lokasi_text', $pengaduan->lokasi_text) }}">
                    @error('lokasi_text')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- RT RW --}}
                <div class="row">
                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt', $pengaduan->rt) }}">
                        @error('rt')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3 text-start">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw', $pengaduan->rw) }}">
                        @error('rw')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
                                        class="img-fluid rounded mb-2" style="max-height: 160px; object-fit: cover;">

                                    {{-- Tombol Hapus Gambar --}}
                                    <form action="{{ route('media.delete', $media->media_id) }}" method="POST"
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

                    <form action="{{ route('pengaduan.update', $pengaduan->pengaduan_id) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar (bisa lebih dari satu)</label>
                            <input type="file" name="lampiran_bukti[]" class="form-control bg-dark text-white" multiple>
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

            </form>

        </div>
    </div>
@endsection
