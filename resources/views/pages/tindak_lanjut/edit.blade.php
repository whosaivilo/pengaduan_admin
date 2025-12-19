@extends('layouts.app')
@section('title_page', 'Edit Tindak Lanjut')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">

        <h6 class="mb-4 text-center">Form Edit Tindak Lanjut</h6>

        {{-- ================= FORM UPDATE ================= --}}
        <form action="{{ route('tindak_lanjut.update', $tindakLanjut->tindak_id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Pengaduan --}}
            <div class="mb-3">
                <label class="form-label">Pengaduan</label>
                <input type="text" class="form-control"
                       value="#{{ $tindakLanjut->pengaduan->pengaduan_id }} - {{ $tindakLanjut->pengaduan->judul }}"
                       readonly>
            </div>

            {{-- Petugas --}}
            <div class="mb-3">
                <label class="form-label">Petugas</label>
                <input type="text"
                       name="petugas"
                       class="form-control"
                       value="{{ old('petugas', $tindakLanjut->petugas) }}">
                @error('petugas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Aksi --}}
            <div class="mb-3">
                <label class="form-label">Aksi</label>
                <textarea name="aksi"
                          class="form-control"
                          rows="3">{{ old('aksi', $tindakLanjut->aksi) }}</textarea>
                @error('aksi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catatan --}}
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan"
                          class="form-control"
                          rows="3">{{ old('catatan', $tindakLanjut->catatan) }}</textarea>
            </div>

            {{-- TAMBAH LAMPIRAN BARU --}}
            <div class="mb-4">
                <label class="form-label">Tambah Lampiran Baru</label>
                <input type="file"
                       name="lampiran_bukti[]"
                       class="form-control"
                       multiple>

                @error('lampiran_bukti.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- AKSI --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Update Tindak Lanjut
                </button>
                <a href="{{ route('tindak_lanjut.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
        {{-- =============== END FORM UPDATE =============== --}}


    </div>
</div>
@endsection
