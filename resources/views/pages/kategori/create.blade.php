@extends('layouts.app')
@section('title_page', 'Tambah Kategori')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Form Tambah Kategori Pengaduan Baru</h6>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-light">
                Kembali
            </a>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label">Nama<span class="text-danger">*</span></label>
                <input type="text"
                       name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SLA --}}
            <div class="mb-3">
                <label class="form-label">SLA (Maksimal Hari Penyelesaian)<span class="text-danger">*</span></label>
                <input type="number"
                       name="sla_hari"
                       min="1"
                       class="form-control @error('sla_hari') is-invalid @enderror"
                       value="{{ old('sla_hari') }}">
                @error('sla_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prioritas --}}
            <div class="mb-4">
                <label class="form-label">Prioritas<span class="text-danger">*</span></label>
                <select name="prioritas"
                        class="form-select @error('prioritas') is-invalid @enderror">
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
                @error('prioritas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Aksi --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">
                    Simpan Data Kategori
                </button>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-light">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
