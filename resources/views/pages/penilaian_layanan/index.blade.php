@extends('layouts.app')
@section('title_page', 'Penilaian Layanan')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

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
                        <div class="col-md-2">
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
                            <th>#</th>
                            <th>Pengaduan ID</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($semua_penilaian as $item)
                            <tr>
                                <td>{{ ($semua_penilaian->currentPage() - 1) * $semua_penilaian->perPage() + $loop->iteration }}
                                </td>

                                {{-- Link detail pengaduan --}}
                                <td>
                                    <a href="{{ route('pengaduan.show', $item->pengaduan_id) }}" class="text-danger">
                                        #{{ $item->pengaduan_id }}
                                    </a>
                                </td>

                                <td>{{ $item->rating }} / 5</td>

                                <td>{{ Str::limit($item->komentar, 50) }}</td>



                                <td>
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
