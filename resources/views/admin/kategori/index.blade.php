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
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">No</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->kategori_id }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $kategori->sla_hari }} hari</td>
                                {{-- KOLOM 5: PRIORITAS (Tambahkan Badge) --}}
                                <td>
                                    @php
                                        $badgeClass = match ($kategori->prioritas) {
                                            'Urgent' => 'bg-danger',
                                            'Important' => 'bg-warning',
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
                                            href="{{ route('kategori.edit', $kategori->kategori_id) }}">Edit</a>

                                        <form action="{{ route('kategori.destroy', $kategori->kategori_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data {{ $kategori->nama }}?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
