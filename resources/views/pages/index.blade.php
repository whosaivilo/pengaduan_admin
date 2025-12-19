@extends('layouts.app')
@section('title_page', 'Dashboard')

@section('content')

    {{-- =======================
KARTU STATISTIK
======================= --}}
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

            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-star fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Rata-rata Rating ({{ $total_penilaian }})</p>
                        <h6 class="mb-0">
                            {{ $rata_rata_rating > 0 ? number_format($rata_rata_rating, 2) . ' / 5' : 'N/A' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =======================
TABEL PENGADUAN
======================= --}}
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">
            <div class="d-flex justify-content-between mb-4">
                <h6 class="mb-0">5 Pengaduan Terbaru</h6>
                <a href="{{ route('pengaduan.index') }}">Show All</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr class="text-white">
                            <th>#</th>
                            <th>No Tiket</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduan_terbaru as $pengaduan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengaduan->nomor_tiket }}</td>
                                <td>{{ $pengaduan->judul }}</td>
                                <td>{{ $pengaduan->warga->nama ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $pengaduan->status === 'Selesai' ? 'success' : 'warning' }}">
                                        {{ $pengaduan->status }}
                                    </span>
                                </td>
                                <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $pengaduan->pengaduan_id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- =======================
CHART
======================= --}}
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">

            <div class="col-lg-6">
                <div class="bg-secondary rounded p-4 text-center">
                    <h6>Status Pengaduan</h6>
                    <canvas id="statusChart" height="150"></canvas>
                    <small class="{{ $insightClass }}">{{ $insightText }}</small>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="bg-secondary rounded p-4 text-center">
                    <h6>Persebaran Wilayah (RT/RW)</h6>
                    <canvas id="wilayahChart" height="200"></canvas>
                </div>
            </div>


        </div>
    </div>


@endsection


@section('scripts')
    <script>
        const statusCtx = document.getElementById('statusChart').getContext('2d');

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($chartStatus)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($chartStatus)) !!},
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)', // Diproses
                        'rgba(40, 167, 69, 0.8)' // Selesai
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // BALIKKAN ke true
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }

        });
        const wilayahCtx = document.getElementById('wilayahChart').getContext('2d');

        new Chart(wilayahCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelWilayah) !!},
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: {!! json_encode($dataWilayah) !!},
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(32, 201, 151, 0.8)',
                        'rgba(111, 66, 193, 0.8)'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
