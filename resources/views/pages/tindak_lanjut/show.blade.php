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
                                        data-image="{{ asset('storage/tindak/' . $m->file_name) }}">
                                        Lihat
                                    </a>

                                    {{-- Tombol hapus --}}
                                    <form action="{{ route('media.delete', $m->media_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus lampiran ini?')"
                                            class="btn btn-danger btn-sm">
                                            Hapus
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
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <img id="previewImage" src="" class="img-fluid rounded">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const previewImage = document.getElementById('previewImage');

            document.querySelectorAll('.view-image').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const imgSrc = this.getAttribute('data-image');
                    previewImage.src = imgSrc;
                    modal.show();
                });
            });
        });
    </script>


@endsection
