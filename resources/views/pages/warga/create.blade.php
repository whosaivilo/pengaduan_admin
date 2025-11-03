@extends('layouts.app')
@section('title_page','Tambah Data Warga')
@section('content')

        <!-- Form Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4 justify-content-center">

                <div class="col-sm-12 col-xl-8">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Form Tambah Data Warga Baru</h6>


                        {{-- FORM ACTION: Mengarah ke WargaController@store (route: warga.store) --}}
                        <form action="{{ route('warga.store') }}" method="POST">
                            @csrf

                            <h6 class="mt-4 mb-3 text-primary">Data Identitas</h6>

                            {{-- 1. NIK (No. KTP) --}}
                            <div class="mb-3">
                                <label for="no_ktp" class="form-label">NIK (No. KTP) <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                    id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}">
                                @error('no_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-white-50">NIK harus 16 digit dan unik.</div>
                            </div>

                            {{-- 2. Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 3. Jenis Kelamin --}}
                            <div class="mb-3">
                                <label class="form-label d-block">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                        id="lakiLaki" value="Laki-laki"
                                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                        id="perempuan" value="Perempuan"
                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="text-danger mt-1" style="font-size: 0.875em;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- 4. Agama --}}
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('agama') is-invalid @enderror" id="agama"
                                    name="agama">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>
                                        Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>
                                        Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>
                                        Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 5. Pekerjaan --}}
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                    id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="mt-4 mb-3 text-primary">Kontak & Alamat</h6>

                            {{-- 6. Telp --}}
                            <div class="mb-3">
                                <label for="telp" class="form-label">No. Telepon <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('telp') is-invalid @enderror"
                                    id="telp" name="telp" value="{{ old('telp') }}">
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 7. Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
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
