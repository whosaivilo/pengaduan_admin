@extends('layouts.app')
@section('title_page', 'Kategori Pengaduan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Kategori Pengaduan</h6>

                <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                    + Tambah Kategori Pengaduan
                </a>
            </div>

            <div class="table-responsive">
                <form method="GET" action="{{ route('kategori.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="prioritas" class="form-select" onchange="this.form.submit()">
                                <option value="">---Prioritas---</option>
                                <option value="Rendah" {{ request('prioritas') == 'Rendah' ? 'selected' : '' }}>
                                    Rendah</option>
                                <option value="Sedang" {{ request('prioritas') == 'Sedang' ? 'selected' : '' }}>
                                    Sedang</option>
                                <option value="Tinggi" {{ request('prioritas') == 'Tinggi' ? 'selected' : '' }}>
                                    Tinggi</option>
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
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="btn btn-primary"
                                        id="clear-search"> Clear</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </form>
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">SLA</th>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data warga yang dikirim dari Controller --}}
                        @forelse ($semua_kategori as $kategori)
                            <tr>
                                <td>{{ $kategori->kategori_id }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $kategori->sla_hari }} hari</td>
                                {{-- KOLOM 5: PRIORITAS (Tambahkan Badge) --}}
                                <td>
                                    @php
                                        $badgeClass = match ($kategori->prioritas) {
                                            'Tinggi' => 'bg-danger',
                                            'Sedang' => 'bg-warning',
                                            default => 'bg-info',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $kategori->prioritas }}</span>
                                </td>
                                {{-- KOLOM 6: AKSI --}}
                                <td>
                                    {{-- Tambahkan d-flex di <td> atau bungkus dalam div d-flex --}}
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-info me-1"
                                            href="{{ route('kategori.edit', $kategori->kategori_id) }}">
                                        <i class="fa fa-eye"></i></a>

                                        <form action="{{ route('kategori.destroy', $kategori->kategori_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data {{ $kategori->nama }}?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $semua_kategori->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

@endsection
