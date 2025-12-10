@extends('layouts.app')
@section('title_page', 'Detail Penilaian Layanan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-10 mx-auto">
            <div class="bg-secondary rounded p-4">

                {{-- HEADER --}}
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="text-primary mb-0">Detail Penilaian #{{ $penilaian->penilaian_id }}</h4>
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="bg-dark rounded p-4 h-100">
                            <h5 class="text-white mb-3 border-bottom pb-2">Detail Umpan Balik</h5>

                            <div class="mb-3">
                                <p class="text-light mb-1"><strong>Rating Layanan:</strong></p>
                                <div class="d-flex align-items-center">
                                    <span class="h3 text-warning me-2">{{ $penilaian->rating ?? 'N/A' }}</span>
                                    <div class="text-warning fs-5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($penilaian->rating ?? 0))
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-light ms-2">/ 5 Bintang</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-light mb-2"><strong>Komentar Warga:</strong></p>
                                <div class="p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                                    <p class="mb-2 text-white">
                                        {{ $penilaian->komentar ?? 'Tidak ada komentar.' }}
                                    </p>
                                    <div class="text-end">
                                        <small class="text-light-50">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $penilaian->created_at->format('d F Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="bg-dark rounded p-4 h-100">
                            <h5 class="text-white mb-3 border-bottom pb-2">Konteks Pengaduan</h5>

                            <div class="mb-3">
                                <p class="text-light mb-1"><strong>Pengaduan:</strong></p>
                                <a href="{{ route('pengaduan.show', $penilaian->pengaduan->pengaduan_id) }}"
                                   class="text-danger text-decoration-none">
                                    <i class="fa fa-link me-1"></i>#{{ $penilaian->pengaduan->pengaduan_id }} - {{ $penilaian->pengaduan->judul }}
                                </a>
                            </div>

                            <div class="mb-3">
                                <p class="text-light mb-1"><strong>Status:</strong></p>
                                <span class="badge bg-success">{{ $penilaian->pengaduan->status }}</span>
                            </div>

                            <hr class="text-white-50 my-4">

                            <h6 class="text-white mb-3">Detail Tindak Lanjut yang Dinilai:</h6>

                            @php
                                $tindakLanjut = $penilaian->pengaduan->tindak_lanjut->last();
                            @endphp

                            @if ($tindakLanjut)
                                <div class="mb-3">
                                    <p class="text-light mb-1"><strong>Petugas:</strong></p>
                                    <p class="text-white">{{ $tindakLanjut->petugas }}</p>
                                </div>

                                <div class="mb-3">
                                    <p class="text-light mb-1"><strong>Aksi:</strong></p>
                                    <p class="text-white">{{ $tindakLanjut->aksi }}</p>
                                </div>

                                <div class="mb-3">
                                    <p class="text-light mb-1"><strong>Catatan:</strong></p>
                                    <p class="text-white">{{ $tindakLanjut->catatan }}</p>
                                </div>

                                <div class="mb-3">
                                    <p class="text-light mb-1"><strong>Tanggal Tindakan:</strong></p>
                                    <p class="text-white">{{ $tindakLanjut->created_at->format('d F Y H:i') }}</p>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fa fa-exclamation-triangle me-2"></i>
                                    Belum ada detail tindak lanjut.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTON --}}
                {{-- <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('penilaian.destroy', $penilaian->penilaian_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus penilaian ini?')">
                            <i class="fa fa-trash me-2"></i>Hapus Penilaian
                        </button>
                    </form>
                </div> --}}

            </div>
        </div>
    </div>
@endsection
