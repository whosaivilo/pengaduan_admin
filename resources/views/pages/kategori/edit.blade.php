@extends('layouts.app')
@section('title_page', 'Edit Kategori Pengaduan')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Edit Kategori Pengaduan</h6>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-light">
                Kembali
            </a>
        </div>

        <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Kategori --}}
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text"
                       name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $kategori->nama) }}"
                       placeholder="Masukkan nama kategori">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SLA Hari --}}
            <div class="mb-3">
                <label class="form-label">SLA (Hari)</label>
                <input type="number"
                       name="sla_hari"
                       min="1"
                       class="form-control @error('sla_hari') is-invalid @enderror"
                       value="{{ old('sla_hari', $kategori->sla_hari) }}">
                @error('sla_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prioritas --}}
            <div class="mb-4">
                <label class="form-label">Prioritas</label>
                <select name="prioritas"
                        class="form-select @error('prioritas') is-invalid @enderror">
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="Tinggi" {{ old('prioritas', $kategori->prioritas) == 'Tinggi' ? 'selected' : '' }}>
                        Tinggi
                    </option>
                    <option value="Sedang" {{ old('prioritas', $kategori->prioritas) == 'Sedang' ? 'selected' : '' }}>
                        Sedang
                    </option>
                    <option value="Rendah" {{ old('prioritas', $kategori->prioritas) == 'Rendah' ? 'selected' : '' }}>
                        Rendah
                    </option>
                </select>
                @error('prioritas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Aksi --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">
                    Simpan Perubahan
                </button>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-light">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
