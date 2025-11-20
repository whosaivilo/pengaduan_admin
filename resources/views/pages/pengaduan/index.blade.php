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
                {{-- FILTERABLE --}}
                <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3 me-2">
                            {{-- Gunakan d-flex untuk menempatkan select dan tombol clear secara horizontal --}}
                            <div class="d-flex align-items-center">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">---Status---</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>
                                        Diproses</option>
                                    <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>
                                        Baru</option>
                                </select>

                                {{-- Tombol Clear Filter (ikon X). Diberi class input-group-text agar tingginya sama dengan field form lain, dan p-0 untuk mengurangi padding. --}}
                                @if (request()->has('status') && request('status') != '')
                                    <a href="{{ request()->fullUrlWithoutQuery(['status']) }}"
                                        class="btn btn-outline-light input-group-text" style="height: 100%;"
                                        title="Clear Status Filter">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- **PERBAIKAN 2: Memperpanjang Field Search** --}}

                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" id="exampleInputIconRight"
                                    value="{{ request('search') }}" placeholder="Search" aria-label="Search">
                                <button type="submit" class="input-group-text **text-danger**" id="basic-addon2">
                                    <i class="fa fa-search"></i>
                                </button>

                                {{-- **PERBAIKAN 3: Link Clear Search yang Benar** --}}
                                @if (request('search'))
                                    <a href="{{ request()->fullUrlWithoutQuery(['search']) }}" class="btn btn-primary"
                                        id="clear-search">Clear</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
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
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data pengaduan --}}
                        @forelse ($semua_pengaduan as $pengaduan)
                            <tr>
                                <td>{{ ($semua_pengaduan->currentPage() - 1) * $semua_pengaduan->perPage() + $loop->iteration }}
                                </td>

                                {{-- POSISI 2: NO. TIKET ASLI --}}
                                <td>{{ $pengaduan->nomor_tiket }}</td>

                                {{-- POSISI 3: WARGA ID --}}
                                <td>{{ $pengaduan->warga_id }}</td>

                                {{-- POSISI 4: KATEGORI (MASUKKAN LOGIC DI SINI) --}}
                                <td>{{ $pengaduan->kategori_id }}</td>

                                {{-- POSISI 4: JUDUL (MASUKKAN LOGIC DI SINI) --}}
                                <td>{{ $pengaduan->judul }}</td>

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

                                <td>
                                    <div class="d-flex">
                                        {{-- Tombol DETAIL (CRUD READ Detail) --}}
                                        <a class="btn btn-sm btn-info me-1"
                                            href="{{ route('pengaduan.show', $pengaduan->pengaduan_id) }}">
                                            <i class="fa fa-eye"></i></a>


                                        {{-- Tombol HAPUS (CRUD DELETE) --}}
                                        <form action="{{ route('pengaduan.destroy', $pengaduan->pengaduan_id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-1"
                                                onclick="return confirm('Yakin hapus pengaduan ini?')">
                                                <i class="fa fa-trash"></i>
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
            <div class="mt-3">
                {{ $semua_pengaduan->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
