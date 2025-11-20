@extends('layouts.app')
@section('title_page', 'Detail Pengaduan')
@section('content')


    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-10">

                {{-- KARTU DETAIL PENGADUAN --}}
                <div class="bg-secondary rounded p-4 mb-4">
                    <h5 class="mb-3 text-primary">Detail Pengaduan #{{ $pengaduan->nomor_tiket }}</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pelapor:</strong> {{ $pengaduan->warga->nama ?? 'N/A' }}</p>
                            <p><strong>Lokasi (RT/RW):</strong> {{ $pengaduan->lokasi_text }} (RT
                                {{ $pengaduan->rt }}/RW {{ $pengaduan->rw }})</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Tanggal Diajukan:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}
                            </p>
                            <p><strong>Kategori:</strong> {{ $pengaduan->kategori->nama ?? 'N/A' }}

                            </p>
                            <p><strong>Status:</strong>
                                @php
                                    $badgeClass = match ($pengaduan->status) {
                                        'Baru' => 'bg-danger',
                                        'Diproses' => 'bg-warning',
                                        'Selesai' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $pengaduan->status }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="text-white-50">

                    {{-- DESKRIPSI (Textarea non-editable) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                        <textarea class="form-control bg-dark text-white" rows="4" readonly>{{ $pengaduan->deskripsi }}</textarea>
                    </div>

                    @if ($pengaduan->media->where('tipe_file', 'pengaduan')->count())
                        @foreach ($pengaduan->media as $media)
                            <img src="{{ asset('storage/' . $media->path_file) }}" width="200">
                        @endforeach
                    @else
                        <p class="text-white-50">Tidak ada lampiran bukti.</p>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection
