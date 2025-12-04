@extends('layouts.app')
@section('title_page', 'Detail Tindak Lanjut')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-10 mx-auto">
            <div class="bg-secondary rounded p-4">

                <h4 class="text-primary mb-3">Detail Tindak Lanjut #{{ $tindak->tindak_id }}</h4>

                <p><strong>Pengaduan:</strong> #{{ $tindak->pengaduan->nomor_tiket }} - {{ $tindak->pengaduan->judul }}</p>
                <p><strong>Petugas:</strong> {{ $tindak->petugas }}</p>
                <p><strong>Aksi:</strong> {{ $tindak->aksi }}</p>
                <p><strong>Catatan:</strong> {{ $tindak->catatan }}</p>
                <p><strong>Tanggal:</strong> {{ $tindak->created_at->format('d F Y H:i') }}</p>

                <hr class="text-white-50">
                <p class="text-danger">Lampiran Bukti</p>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60%">Nama File</th>
                            <th style="width: 40%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tindak->media as $m)
                            <tr>
                                <td>{{ $m->file_name }}</td>
                                <td>
                                    {{-- Tombol lihat --}}
                                    <a href="#" class="btn btn-info btn-sm view-image"
                                        onclick="showImageModal('{{ asset('storage/tindak/' . $m->file_name) }}')">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    {{-- Tombol hapus --}}
                                    <form action="{{ route('media.delete', $m->media_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus lampiran ini?')"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($tindak->media->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada lampiran</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <a href="{{ route('tindak_lanjut.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </div>
        </div>
    </div>
     <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Lampiran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" class="img-fluid rounded border">
                </div>
            </div>
        </div>
    </div>
    <script>
        function showImageModal(src) {
            document.getElementById('previewImage').src = src;
            let modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }
    </script>


@endsection
