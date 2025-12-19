@extends('layouts.app')

@section('title_page', 'Tambah Tindak Lanjut')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">
            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Form Catat Tindak Lanjut</h6>

                    {{-- FORM ACTION --}}
                    <form action="{{ route('tindak_lanjut.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. Pengaduan ID (Dropdown Pilihan Nomor Tiket) --}}
                        <div class="mb-3">
                            <label for="pengaduan_id" class="form-label text-white">Pilih Pengaduan / Nomor Tiket <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('pengaduan_id') is-invalid @enderror" id="pengaduan_id"
                                name="pengaduan_id" required>
                                <option value="">-- Pilih Pengaduan --</option>

                                {{-- Looping data pengaduan yang BELUM SELESAI --}}
                                @foreach ($pengaduan as $p)
                                    <option value="{{ $p->pengaduan_id }}"
                                        {{ old('pengaduan_id') == $p->pengaduan_id ? 'selected' : '' }}>
                                        {{ $p->nomor_tiket }} - {{ Str::limit($p->judul, 40) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pengaduan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Nama Petugas --}}
                        <div class="mb-3">
                            <label for="petugas" class="form-label text-white">Nama Petugas Pelaksana <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('petugas') is-invalid @enderror" id="petugas"
                                name="petugas" value="{{ old('petugas', Auth::user()->name ?? 'Admin System') }}"
                                placeholder="Contoh: Admin System" required>
                            @error('petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Aksi Petugas --}}
                        <div class="mb-3">
                            <label for="aksi" class="form-label text-white">Aksi Petugas <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('aksi') is-invalid @enderror" id="aksi"
                                name="aksi" value="{{ old('aksi') }}" placeholder="" required>
                            @error('aksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 4. Catatan Detail --}}
                        <div class="mb-3">
                            <label for="catatan" class="form-label text-white">Catatan Detail</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LAMPIRAN FILE --}}
                        <div class="mb-3">
                            <label for="lampiran_bukti" class="form-label text-white">
                                Lampiran Bukti Tindak Lanjut <span class="text-danger">*</span>

                            </label>

                            <input type="file" class="form-control bg-dark @error('lampiran_bukti') is-invalid @enderror"
                                id="lampiran_bukti" name="lampiran_bukti[]" multiple>

                            @error('lampiran_bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('tindak_lanjut.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Tindak Lanjut</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
