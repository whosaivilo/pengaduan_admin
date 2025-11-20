@extends('layouts.app')
@section('title_page', 'Data Warga')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Data Warga Terdaftar</h6>
                {{-- Tombol Tambah Warga Baru (CRUD CREATE) --}}
                <a href="{{ route('warga.create') }}" class="btn btn-primary">
                    + Tambah Data Warga
                </a>
            </div>

            <div class="table-responsive">
                {{-- FILTERABLE --}}
                <form method="GET" action="{{ route('warga.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3 me-2">
                            <div class="d-flex align-items-center">
                                <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()">
                                    <option value="">---Jenis Kelamin---</option>
                                    <option value="Perempuan"
                                        {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                    <option value="Laki-laki"
                                        {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                </select>
                                @if (request()->has('jenis_kelamin') && request('jenis_kelamin') != '')
                                    <a href="{{ request()->fullUrlWithoutQuery(['jenis_kelamin']) }}"
                                        class="btn btn-outline-light input-group-text" style="height: 100%;"
                                        title="Clear Jenis Kelamin Filter">
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
                            <th scope="col">#</th>
                            <th scope="col">NIK (No. KTP)</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Agama</th>
                            <th scope="col">Pekerjaan</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data warga yang dikirim dari Controller --}}
                        @forelse ($semua_warga as $warga)
                            <tr>
                                <td>{{ ($semua_warga->currentPage() - 1) * $semua_warga->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $warga->no_ktp }}</td>
                                <td>{{ $warga->nama }}</td>
                                <td>{{ $warga->jenis_kelamin }}</td>
                                <td>{{ $warga->agama }}</td>
                                <td>{{ $warga->pekerjaan }}</td>
                                <td>{{ $warga->telp }}</td>
                                <td>{{ $warga->email }}</td>
                                <td>
                                    <div class="d-flex">
                                        {{-- Tombol EDIT (CRUD UPDATE) --}}
                                        <a class="btn btn-sm btn-warning me-1"
                                            href="{{ route('warga.edit', $warga->warga_id) }}">
                                            <i class="fa fa-edit"></i></a>

                                        {{-- Tombol DETAIL (CRUD READ Detail) --}}
                                        <a class="btn btn-sm btn-info me-1"
                                            href="{{ route('warga.show', $warga->warga_id) }}">
                                            <i class="fa fa-eye"></i></a>

                                        {{-- Tombol HAPUS --}}
                                        <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST"
                                            style="display:inline-block;"> @csrf @method('DELETE') <button type="submit"
                                                class="btn btn-sm btn-danger me-1"
                                                onclick="return confirm('Yakin ingin menghapus data {{ $warga->nama }}?')">
                                                <i class="fa fa-trash"></i> </button> </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Warga belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $semua_warga->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
