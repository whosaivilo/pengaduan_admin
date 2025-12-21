@extends('layouts.app')
@section('title_page', 'Edit Data Warga')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Form Edit Data Warga: {{ $warga->nama }}</h6>

                    {{-- Tampilkan Flash Data di sini --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- FORM ACTION: Mengarah ke WargaController@store (route: warga.store) --}}
                    <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="mt-4 mb-3 text-primary">Data Identitas</h6>

                        {{-- 1. NIK (No. KTP) --}}
                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">NIK (No. KTP) <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                value="{{ $warga->no_ktp }}" readonly>
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- 2. Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') ?? $warga->nama }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Jenis Kelamin --}}
                        <div class="mb-3">
                            <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lakiLaki"
                                    value="Laki-laki"
                                    {{ (old('jenis_kelamin') ?? $warga->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                    value="Perempuan"
                                    {{ (old('jenis_kelamin') ?? $warga->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                            @error('jenis_kelamin')
                                <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        @php
                            $selectedAgama = old('agama') ?? $warga->agama;
                        @endphp

                        {{-- 4. Agama --}}
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                            <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ $selectedAgama == 'Islam' ? 'selected' : '' }}>Islam
                                </option>
                                <option value="Kristen" {{ $selectedAgama == 'Kristen' ? 'selected' : '' }}>
                                    Kristen</option>
                                <option value="Katolik" {{ $selectedAgama == 'Katolik' ? 'selected' : '' }}>
                                    Katolik</option>
                                <option value="Hindu" {{ $selectedAgama == 'Hindu' ? 'selected' : '' }}>Hindu
                                </option>
                                <option value="Buddha" {{ $selectedAgama == 'Buddha' ? 'selected' : '' }}>
                                    Buddha</option>
                                <option value="Konghucu" {{ $selectedAgama == 'Konghucu' ? 'selected' : '' }}>
                                    Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 5. Pekerjaan --}}
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') ?? $warga->pekerjaan }}">
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="mt-4 mb-3 text-primary">Kontak & Alamat</h6>

                        {{-- 6. Telp --}}
                        <div class="mb-3">
                            <label for="telp" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('telp') is-invalid @enderror" id="telp"
                                name="telp" value="{{ old('telp') ?? $warga->telp }}">
                            @error('telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 7. Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') ?? $warga->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan Data Warga</button>
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary mt-3">Batal</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Form End -->

@endsection
