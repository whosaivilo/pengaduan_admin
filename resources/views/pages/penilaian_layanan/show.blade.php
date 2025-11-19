
@extends('layouts.app')
@section('title page' | 'Penilai Layanan')
@section('content')
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between w-100 flex-wrap mb-3">
            <h1 class="h4">Detail Penilaian #{{ $penilaian->penilaian_id }}</h1>
        </div>

        <div class="row">
            {{-- KOLOM KIRI: DETAIL PENILAIAN --}}
            <div class="col-md-6">
                <div class="card border-0 shadow mb-4">
                    <div class="card-header">Detail Umpan Balik</div>
                    <div class="card-body">
                        <h5>Rating Layanan:</h5>
                        <p class="h3 text-warning">{{ $penilaian->rating ?? 'N/A' }} / 5 Bintang</p>

                        <h5 class="mt-4">Komentar Warga:</h5>
                        <blockquote class="blockquote bg-light p-3 rounded">
                            <p class="mb-0">{{ $penilaian->komentar ?? 'Tidak ada komentar.' }}</p>
                            <footer class="blockquote-footer">Diberikan pada {{ $penilaian->created_at->format('d F Y H:i') }}</footer>
                        </blockquote>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: KONTEKS PENGADUAN & TINDAK LANJUT --}}
            <div class="col-md-6">
                <div class="card border-0 shadow mb-4">
                    <div class="card-header">Konteks Pengaduan</div>
                    <div class="card-body">

                        {{-- Data Pengaduan (Lazy Loading tanpa load() di controller) --}}
                        <p><strong>ID Pengaduan:</strong> <a href="{{ route('pengaduan.show', $penilaian->pengaduan->pengaduan_id) }}">#{{ $penilaian->pengaduan->pengaduan_id }}</a></p>
                        <p><strong>Judul:</strong> {{ $penilaian->pengaduan->judul }}</p>
                        <p><strong>Status Pengaduan:</strong> <span class="badge bg-success">{{ $penilaian->pengaduan->status }}</span></p>

                        <hr>

                        {{-- Data Tindak Lanjut Terakhir (Lazy Loading) --}}
                        <h5>Detail Tindak Lanjut yang Dinilai:</h5>
                        @php
                            // Ambil tindak lanjut terakhir (jika ada relasi hasMany)
                            $tindakLanjut = $penilaian->pengaduan->tindak_lanjut->last();
                        @endphp

                        @if ($tindakLanjut)
                            <p><strong>Aksi Petugas:</strong> {{ $tindakLanjut->aksi }}</p>
                            <p><strong>Catatan:</strong> {{ $tindakLanjut->catatan }}</p>
                            <p><strong>Petugas:</strong> {{ $tindakLanjut->petugas }}</p>
                        @else
                            <p class="text-muted">Belum ada detail tindak lanjut yang tersedia.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('penilaian-layanan.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar</a>
    </div>
@endsection
