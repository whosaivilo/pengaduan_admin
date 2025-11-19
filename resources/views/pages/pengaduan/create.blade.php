@extends('layouts.app')
@section('title_page', 'Tambah Pengaduan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Form Ajukan Pengaduan & Aspirasi Warga</h6>

                    {{-- FORM CRUD CREATE PENGADUAN --}}
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- DROPDOWN WARGA PELAPOR (Warga ID) --}}
                        <div class="mb-3">
                            <label for="warga_id" class="form-label text-white">Warga Pelapor <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('warga_id') is-invalid @enderror" id="warga_id"
                                name="warga_id" required>

                                <option value="" disabled selected>-- Pilih Warga Pelapor --</option>

                                {{-- Looping data warga yang dikirim dari Controller --}}
                                @foreach ($semua_warga as $warga)
                                    <option value="{{ $warga->warga_id }}"
                                        {{ old('warga_id') == $warga->warga_id ? 'selected' : '' }}>
                                        {{ $warga->nama }} (NIK: {{ $warga->no_ktp ?? 'Tidak Ada NIK' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- 2. Kategori Pengaduan (Kolom: kategori_id) --}}
                        <div class="mb-3">
                            <label for="kategori_id">Kategori Pengaduan</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>

                                @foreach ($semua_kategori as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">
                                        {{ $kategori->nama }} ({{ $kategori->prioritas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 3. Judul Pengaduan (Kolom: judul) --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul') }}" maxlength="150" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Deskripsi Detail (Kolom: deskripsi) --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Detail <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                style="height: 150px;">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="text-white-50">

                        {{-- 4. Lokasi Kejadian (Kolom: lokasi_text, rt, rw) --}}
                        <h6 class="mt-4 mb-3 text-primary">Informasi Lokasi</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('rt') is-invalid @enderror" id="rt"
                                    name="rt" value="{{ old('rt') }}">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('rw') is-invalid @enderror" id="rw"
                                    name="rw" value="{{ old('rw') }}">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lokasi_text" class="form-label">Alamat/Lokasi Detail <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lokasi_text') is-invalid @enderror"
                                    id="lokasi_text" name="lokasi_text" value="{{ old('lokasi_text') }}">
                                @error('lokasi_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 5. Lampiran Bukti (File Input) --}}
                        <div class="mb-3 mt-3">
                            <label for="lampiran_bukti" class="form-label">Unggah Bukti (Foto/Media)</label>
                            <input class="form-control bg-dark @error('lampiran_bukti') is-invalid @enderror" type="file"
                                id="lampiran_bukti" name="lampiran_bukti">
                            @error('lampiran_bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Kirim Pengaduan</button>
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary mt-3">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
