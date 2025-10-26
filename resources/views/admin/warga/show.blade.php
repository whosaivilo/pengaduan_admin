@extends('layouts.app')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4 text-primary">Detail Data Warga: {{ $warga->nama }}</h6>
                    <hr class="text-white-50 mb-4">

                    <h6 class="mt-4 mb-3 text-primary">Data Identitas</h6>

                    {{-- 1. NIK (No. KTP) --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">NIK (No. KTP)</label>
                        <h5 class="text-white fw-bold">{{ $warga->no_ktp }}</h5>
                    </div>

                    {{-- 2. Nama --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Nama Lengkap</label>
                        <h5 class="text-white fw-bold">{{ $warga->nama }}</h5>
                    </div>

                    {{-- 3. Jenis Kelamin --}}
                    <div class="mb-3">
                        <label class="form-label d-block text-white-50">Jenis Kelamin</label>
                        <h5 class="text-white fw-bold">{{ $warga->jenis_kelamin }}</h5>
                    </div>

                    {{-- 4. Agama --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Agama</label>
                        <h5 class="text-white fw-bold">{{ $warga->agama }}</h5>
                    </div>

                    {{-- 5. Pekerjaan --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Pekerjaan</label>
                        <h5 class="text-white fw-bold">{{ $warga->pekerjaan }}</h5>
                    </div>

                    <h6 class="mt-4 mb-3 text-primary">Kontak & Alamat</h6>

                    {{-- 6. Telp --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">No. Telepon</label>
                        <h5 class="text-white fw-bold">{{ $warga->telp }}</h5>
                    </div>

                    {{-- 7. Email --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Email</label>
                        <h5 class="text-white fw-bold">{{ $warga->email ?? 'Tidak Ada' }}</h5>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning me-2">Edit Data</a>
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
