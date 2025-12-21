@extends('layouts.app')

@section('title_page', 'Tambah Penilaian Layanan')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
          <div class="col-sm-12 col-xl-7">
                <div class="bg-secondary rounded p-3">
                    <h6 class="mb-4">Formulir Penilaian Layanan</h6>

                    {{-- FORM ACTION --}}
                    {{-- Ganti route tindak_lanjut.store menjadi penilaian.store --}}
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="pengaduan_id" class="form-label text-white">Pilih Pengaduan yang Selesai Ditindak
                                Lanjut <span class="text-danger">*</span></label>

                            <select class="form-select @error('pengaduan_id') is-invalid @enderror" id="pengaduan_id"
                                name="pengaduan_id" required>
                                <option value="">-- Pilih Pengaduan --</option>

                                {{-- Data $pengaduan ini berasal dari Controller create() --}}
                                @foreach ($pengaduan as $p)
                                    <option value="{{ $p->pengaduan_id }}"
                                        {{ old('pengaduan_id') == $p->pengaduan_id ? 'selected' : '' }}>
                                        {{ $p->nomor_tiket }} - {{ Str::limit($p->judul, 50) }}
                                    </option>
                                @endforeach

                            </select>
                            @error('pengaduan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- 2. Rating (Kolom rating) --}}
                        <div class="mb-3">
                            <label for="rating" class="form-label text-white">Rating Kepuasan (1 - 5) <span
                                    class="text-danger">*</span></label>
                            <select class="form-select **form-select-sm** @error('rating') is-invalid @enderror"
                                id="rating" name="rating" required>
                                <option value="">-- Pilih Rating --</option>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 - Sangat Puas</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 - Puas</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 - Cukup</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 - Kurang Puas
                                </option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 - Sangat Tidak Puas
                                </option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Komentar (Kolom komentar) --}}
                        <div class="mb-3">
                            <label for="komentar" class="form-label text-white">Komentar/Masukan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('komentar') is-invalid @enderror" id="komentar" name="komentar" rows="3"
                                required>{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            {{-- Ganti route Batal --}}
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                            {{-- Ganti button text --}}
                            <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
