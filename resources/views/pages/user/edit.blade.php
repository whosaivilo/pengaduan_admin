@extends('layouts.app')
@section('title_page', 'Edit Data User')
@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4 justify-content-center">

            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Form Tambah Data User Baru</h6>


                    {{-- FORM ACTION: Mengarah ke UserController@store (route: user.store) --}}
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h6 class="mt-4 mb-3 text-primary">Data User</h6>

                        {{-- 1. Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') ?? $user->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-white-50">Nama maksimal terdiri dari 100 digit</div>
                        </div>

                        {{-- 2. Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') ?? $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. ROLE (Tambahan) --}}
                        <div class="mb-3">
                            <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="">Pilih Role</option>
                                @php
                                    $currentRole = old('role') ?? $user->role;
                                @endphp
                                <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $currentRole == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         {{-- 4. Profile Picture  --}}
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Ganti Foto Profil</label>
                            {{-- Tampilkan foto lama jika ada --}}
                            @if ($user->profile_picture)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil Lama" style="max-width: 150px; border-radius: 8px;">
                                    <div class="form-text text-white-50 mt-1">Foto lama</div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                id="profile_picture" name="profile_picture">
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-white-50">Abaikan jika tidak ingin mengganti. Maks. 2MB.</div>
                        </div>

                        {{-- 3. Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" value="">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- 4. password_confirmation --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" value="">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Batal</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Form End -->


@endsection
