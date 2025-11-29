@extends('layouts.app')
@section('title_page', 'Detail Pengaduan')
@section('content')


    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-10">

                {{-- KARTU DETAIL PENGADUAN --}}
                <div class="bg-secondary rounded p-4 mb-4">
                    <h5 class="mb-3 text-primary">Detail Pengaduan #{{ $pengaduan->nomor_tiket }}</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pelapor:</strong> {{ $pengaduan->warga->nama ?? 'N/A' }}</p>
                            <p><strong>Lokasi (RT/RW):</strong> {{ $pengaduan->lokasi_text }} (RT
                                {{ $pengaduan->rt }}/RW {{ $pengaduan->rw }})</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Tanggal Diajukan:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}
                            </p>
                            <p><strong>Kategori:</strong> {{ $pengaduan->kategori->nama ?? 'N/A' }}

                            </p>
                            <p><strong>Status:</strong>
                                @php
                                    $badgeClass = match ($pengaduan->status) {
                                        'Diproses' => 'bg-warning',
                                        'Selesai' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $pengaduan->status }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="text-white-50">

                    {{-- DESKRIPSI (Textarea non-editable) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                        <textarea class="form-control bg-dark text-white" rows="4" readonly>{{ $pengaduan->deskripsi }}</textarea>
                    </div>


                    <p class="mt-4 mb-3 text-primary">Lampiran Pengaduan</p>

                    @if ($pengaduan->media->count())
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 60%">Nama File</th>
                                    <th style="width: 40%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengaduan->media as $m)
                                    <tr>
                                        <td>{{ $m->file_name }}</td>
                                        <td>
                                            {{-- Tombol lihat (modal) --}}
                                            <button class="btn btn-info btn-sm"
                                                onclick="showImageModal('{{ asset('storage/pengaduan/' . $m->file_name) }}')">
                                                <i class="fa fa-eye"></i>
                                            </button>

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
                            </tbody>
                        </table>
                    @else
                        <p class="text-white-50">Tidak ada lampiran bukti.</p>
                    @endif

                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                </div>
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
