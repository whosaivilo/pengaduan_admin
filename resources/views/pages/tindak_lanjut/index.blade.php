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
                                @foreach ($tl->pengaduan->media as $m)
                                    <img src="{{ asset($m->path_file) }}"
                                         width="80"
                                         class="img-thumbnail mb-1">
                                @endforeach
                            </td>

                            <td>
                                <form action="{{ route('tindak_lanjut.destroy', $tl->tindak_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus Tindak Lanjut ini?')">
                                        Hapus
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
        </div>
    </div>
</div>
@endsection
