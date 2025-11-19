@extends('layouts.app')

@section('title_page', 'Riwayat Tindak Lanjut')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Tindak Lanjut</h6>
                <a href="{{ route('tindak_lanjut.create') }}" class="btn btn-primary">+ Tambah Tindak Lanjut</a>
            </div>

            <div class="table-responsive">
                {{-- FILTERABLE --}}
                <form method="GET" action="{{ route('tindak_lanjut.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="petugas" class="form-select" onchange="this.form.submit()">
                                <option value="">---Petugas---</option>
                                <option value="Admin Sistem" {{ request('petugas') == 'Admin Sistem' ? 'selected' : '' }}>
                                    Admin Sistem</option>
                                <option value="Petugas Lapangan"
                                    {{ request('petugas') == 'Petugas Lapangan' ? 'selected' : '' }}>
                                    Petugas Lapangan</option>
                                <option value="Petugas Kebersihan"
                                    {{ request('petugas') == 'Petugas Kebersihan' ? 'selected' : '' }}>
                                    Petugas Kebersihan</option>
                                <option value="Satpam Lingkungan"
                                    {{ request('petugas') == 'Satpam Lingkungan' ? 'selected' : '' }}>
                                    Satpam Lingkungan</option>
                                <option value="Operator RW" {{ request('petugas') == 'Operator RW' ? 'selected' : '' }}>
                                    Operator RW</option>
                                <option value="Dinas Terkait" {{ request('petugas') == 'Dinas Terkait' ? 'selected' : '' }}>
                                    Dinas Terkait</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" id="exampleInputIconRight"
                                    value="{{ request('search') }}" placeholder="Search" aria-label="Search">
                                <button type="submit" class="input-group-text" id="basic-addon2">
                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>

                                </button>
                                @if (request('search'))
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="btn btn-danger"
                                        id="clear-search"> Clear</a>
                                @endif
                            </div>
                        </div>

                    </div>

                </form>
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th>ID</th>
                            <th>Pengaduan ID</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                            <th>Catatan</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tindakLanjut as $tl)
                            <tr>
                                <td>{{ $tl->tindak_id }}</td>
                                <td>{{ $tl->pengaduan->pengaduan_id }}</td>
                                <td>{{ $tl->petugas }}</td>
                                <td>{{ $tl->aksi }}</td>
                                <td>{{ Str::limit($tl->catatan, 50) }}</td>

                                {{-- LAMPIRAN MEDIA --}}
                                <td>
                                    @if ($tl->lampiran_bukti)
                                        <img src="{{ asset('storage/tindak/' . $tl->lampiran_bukti) }}" width="80">
                                    @else
                                        <span class="text-white-50">Tidak ada</span>
                                    @endif
                                </td>

                                {{--  --}}
                                <td>
                                    <div class="d-flex">
                                        {{-- Tombol EDIT --}}
                                        <a href="{{ route('tindak_lanjut.edit', $tl->tindak_id) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {{-- Tombol DELETE --}}
                                        <form action="{{ route('tindak_lanjut.destroy', $tl->tindak_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus Tindak Lanjut ini?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada riwayat Tindak Lanjut.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-3">
                    {{ $tindakLanjut->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
