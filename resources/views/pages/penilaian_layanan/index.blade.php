@extends('layouts.app')
@section('title_page', 'Penilaian Layanan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4 mb-5">


            {{-- HEADER --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Penilaian Layanan</h6>
                <a href="{{ route('penilaian.create') }}" class="btn btn-primary">+ Tambah Penilaian Layanan</a>
            </div>

            {{-- TABEL --}}
            <div class="table-responsive">
                {{-- FILTERABLE --}}
                <form method="GET" action="{{ route('penilaian.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3 me-2">
                            <div class="d-flex align-items-center">
                                <select name="rating" class="form-select" onchange="this.form.submit()">
                                    <option value="">---Rating---</option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>
                                        1</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>
                                        2</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>
                                        3</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>
                                        4</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>
                                        5</option>
                                </select>
                                @if (request()->has('rating') && request('rating') != '')
                                    <a href="{{ request()->fullUrlWithoutQuery(['rating']) }}"
                                        class="btn btn-outline-light input-group-text" style="height: 100%;"
                                        title="Clear Rating Filter">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" id="exampleInputIconRight"
                                    value="{{ request('search') }}" placeholder="Search" aria-label="Search">
                                <button type="submit" class="input-group-text" id="basic-addon2">
                                    <i class="fa fa-search"></i>
                                </button>
                                @if (request('search'))
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="btn btn-primary"
                                        id="clear-search">Clear</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </form>
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white text-center">
                            <th>#</th>
                            <th>Pengaduan ID</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th >Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($semua_penilaian as $item)
                            <tr>
                                <td class="text-center">{{ ($semua_penilaian->currentPage() - 1) * $semua_penilaian->perPage() + $loop->iteration }}
                                </td>

                                {{-- Link detail pengaduan --}}
                                <td class="text-center">
                                    <a href="{{ route('pengaduan.show', $item->pengaduan_id) }}" class="text-danger">
                                        #{{ $item->pengaduan_id }}
                                    </a>
                                </td>

                                <td class="text-center">{{ $item->rating }} / 5</td>

                                <td>{{ Str::limit($item->komentar, 50) }}</td>



                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                    <a href="{{ route('penilaian.show', $item->penilaian_id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{-- Form Hapus --}}
                                    <form action="{{ route('penilaian.destroy', $item->penilaian_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus penilaian ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data penilaian layanan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-3">
                    {{ $semua_penilaian->links('pagination::bootstrap-5') }}
                </div>
            </div>


        </div>
    </div>
@endsection
