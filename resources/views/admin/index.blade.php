@extends('layouts.app')
@section('title_page','Dashboard')
@section('content')

<div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Pengaduan Masuk</p>
                                <h6 class="mb-0">{{ $total_masuk }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pengaduan Belum Diproses</p>
                                <h6 class="mb-0">{{ $belum_diproses }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pengaduan Selesai Ditangani</p>
                                <h6 class="mb-0">{{ $selesai_ditangani }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            {{-- Daftar Pengaduan Table --}}
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Daftar 5 Pengaduan Terbaru</h6>
                        <a href="{{ route('pengaduan.index') }}">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">#</th>
                                    <th scope="col">No. Tiket</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Pelapor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Diajukan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengaduan_terbaru as $pengaduan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengaduan->nomor_tiket }}</td>
                                        <td>{{ Str::limit($pengaduan->judul, 30) }}</td>
                                        <td>{{ $pengaduan->warga->nama ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                // Logika Badge Status yang sama
                                                $badgeClass = match ($pengaduan->status) {
                                                    'Baru' => 'bg-danger',
                                                    'Diproses' => 'bg-warning',
                                                    'Selesai' => 'bg-success',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $pengaduan->status }}</span>
                                        </td>
                                        <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('pengaduan.show', $pengaduan->pengaduan_id) }}">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada Pengaduan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


@endsection
