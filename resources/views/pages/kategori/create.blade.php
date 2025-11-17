@extends('layouts.app')
@section('title_page', 'Tambah Kategori')
@section('content')

    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Form Tambah Kategori Pengaduan Baru</h6>

                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf

                        <h6 class="mt-4 mb-3 text-primary">Data Kategori</h6>

                        {{-- 1. Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. SLA_Hari --}}
                        <div class="mb-3">
                            <label for="sla_hari" class="form-label">SLA (Maksimal Hari Penyelesaian) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sla_hari') is-invalid @enderror"
                                id="sla_hari" name="sla_hari" value="{{ old('sla_hari') }}" min="1" required>
                            @error('sla_hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- 4. Prioritas --}}
                        <div class="mb-3">
                            <label for="prioritas" class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select class="form-select @error('prioritas') is-invalid @enderror" id="prioritas"
                                name="prioritas">
                                <option value="">-- Pilih prioritas --</option>
                                <option value="Tinggi" {{ old('tinggi') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                                <option value="Sedang" {{ old('sedang') == 'Sedang' ? 'selected' : '' }}>
                                    Sedang</option>
                                <option value="Rendah" {{ old('rendah') == 'Rendah' ? 'selected' : '' }}>
                                    Rendah</option>

                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan Data Kategori</button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-3">Batal</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Form End -->



@endsection
