@extends('layouts.app')
@section('title_page', 'Edit Tindak Lanjut')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <h6 class="mb-4">Form Edit Tindak Lanjut</h6>

            <form action="{{ route('tindak_lanjut.update', $tindakLanjut->tindak_id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Pilih Pengaduan --}}
                <div class="mb-3 text-start">
                    <label for="pengaduan_id" class="form-label">Pengaduan</label>
                    <input type="text" class="form-control"
                        value="#{{ $tindakLanjut->pengaduan->pengaduan_id }} - {{ $tindakLanjut->pengaduan->judul }}"
                        readonly>
                </div>

                {{-- Petugas --}}
                <div class="mb-3 text-start">
                    <label for="petugas" class="form-label">Petugas</label>
                    <input type="text" name="petugas" id="petugas" class="form-control"
                        value="{{ old('petugas', $tindakLanjut->petugas) }}">
                    @error('petugas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Aksi --}}
                <div class="mb-3 text-start">
                    <label for="aksi" class="form-label">Aksi</label>
                    <textarea name="aksi" id="aksi" class="form-control" rows="3">{{ old('aksi', $tindakLanjut->aksi) }}</textarea>
                    @error('aksi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="mb-3 text-start">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $tindakLanjut->catatan) }}</textarea>
                    @error('catatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lampiran --}}
                <div class="mb-3 text-start">
                    <label for="lampiran_bukti" class="form-label">Lampiran (ubah jika perlu)</label>
                    @if ($tindakLanjut->lampiran_bukti)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $tindakLanjut->lampiran_bukti) }}" width="120"
                                class="img-thumbnail" alt="Lampiran">
                        </div>
                    @endif
                    <input type="file" name="lampiran_bukti" id="lampiran_bukti" class="form-control" multiple>
                    @error('lampiran_bukti')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Tindak Lanjut</button>
                <a href="{{ route('tindak_lanjut.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
