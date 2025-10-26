@extends('layouts.app')
@section('title_page', 'Daftar Pengaduan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Seluruh Pengaduan & Aspirasi Warga</h6>
                {{-- Tombol untuk Ajukan Pengaduan (CRUD CREATE) --}}
                <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                    + Ajukan Pengaduan Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">#</th>
                            <th scope="col">No. Tiket</th>
                            <th scope="col">Warga ID</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Diajukan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data pengaduan --}}
                        @forelse ($semua_pengaduan as $pengaduan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- POSISI 2: NO. TIKET ASLI --}}
                                <td>{{ $pengaduan->nomor_tiket }}</td>

                                {{-- POSISI 3: WARGA ID --}}
                                <td>{{ $pengaduan->warga_id }}</td>

                                {{-- POSISI 4: KATEGORI (MASUKKAN LOGIC DI SINI) --}}
                                <td>
                                    @php
                                        // Logika terjemahan Kategori
                                        $kategoriNama = match ((int) $pengaduan->kategori_id) {
                                            1 => 'Infrastruktur',
                                            2 => 'Pelayanan Publik',
                                            3 => 'Keamanan',
                                            default => 'Lainnya',
                                        };
                                        $kategoriBadgeClass = match ((int) $pengaduan->kategori_id) {
                                            1 => 'bg-info',
                                            2 => 'bg-primary',
                                            3 => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $kategoriBadgeClass }}">{{ $kategoriNama }}</span>
                                </td>
                                <td>{{ Str::limit($pengaduan->judul, 50) }}</td> {{-- Memotong judul agar tidak terlalu panjang --}}
                                <td>{{ Str::limit($pengaduan->deskripsi, 50) }}</td> {{-- Memotong judul agar tidak terlalu panjang --}}

                                {{-- Status dengan Badge Warna --}}
                                <td>
                                    @php
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
                                    <div class="d-flex">
                                        {{-- Tombol DETAIL (CRUD READ Detail) --}}
                                        <a class="btn btn-sm btn-info me-1"
                                            href="{{ route('pengaduan.show', $pengaduan->pengaduan_id) }}">Detail</a>


                                        {{-- Tombol HAPUS (CRUD DELETE) --}}
                                        <form action="{{ route('pengaduan.destroy', $pengaduan->pengaduan_id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-1"
                                                onclick="return confirm('Yakin hapus pengaduan ini?')">Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                    </tbody>
                </table>
            </div>
            <tr>
                <td colspan="7" class="text-center">Belum ada data Pengaduan yang masuk.
                </td>
            </tr>
            @endforelse
            </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
