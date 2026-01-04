@extends('layouts.app')
@section('title_page', 'Edit Tindak Lanjut')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <h6 class="mb-4 text-center">Form Edit Tindak Lanjut</h6>

            {{-- ================= FORM UPDATE ================= --}}
            <form action="{{ route('tindak_lanjut.update', $tindakLanjut->tindak_id) }}" method="POST"
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
                    <input type="text" name="petugas" class="form-control"
                        value="{{ old('petugas', $tindakLanjut->petugas) }}">
                    @error('petugas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Aksi --}}
                <div class="mb-3">
                    <label class="form-label">Aksi</label>
                    <textarea name="aksi" class="form-control" rows="3">{{ old('aksi', $tindakLanjut->aksi) }}</textarea>
                    @error('aksi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $tindakLanjut->catatan) }}</textarea>
                </div>

                {{-- ================= GAMBAR SAAT INI ================= --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Lampiran Sebelumnya</label>

                    @if ($tindakLanjut->media->isEmpty())
                        <p class="text-warning">Belum ada lampiran pada tindak lanjut ini.</p>
                    @else
                        <div class="row">
                            @foreach ($tindakLanjut->media as $media)
                                <div class="col-md-3 mb-3">
                                    <div class="bg-dark p-2 rounded text-center">

                                        <img src="{{ asset('storage/tindak/' . $media->file_name) }}"
                                            class="img-fluid rounded mb-2" style="max-height: 160px; object-fit: cover;">

                                        {{-- HAPUS GAMBAR --}}
                                        <form action="{{ route('media.delete', $media->media_id) }}" method="POST"
                                            onsubmit="return confirm('Hapus lampiran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- TAMBAH LAMPIRAN BARU --}}
                <div class="mb-4">
                    <label class="form-label">Tambah Lampiran Baru</label>
                    <input type="file" name="lampiran_bukti[]" class="form-control" multiple>

                    @error('lampiran_bukti.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- AKSI --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Update Tindak Lanjut
                    </button>
                    <a href="{{ route('tindak_lanjut.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>



        </div>
    </div>
@endsection
