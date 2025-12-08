@extends('layouts.app')
@section('title_page', 'Data User')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Data User</h6>
                {{-- Tombol Tambah users Baru (CRUD CREATE) --}}
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    + Tambah Data User
                </a>
            </div>

            <div class="table-responsive">
                <form method="GET" action="{{ route('user.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="role-select" class="form-label"></label>
                            <select name="role" class="form-select" id="role-select" onchange="this.form.submit()">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        {{-- FORM SEARCH --}}
                        <div class="col-md-3">
                            <label for="verified-select" class="form-label"></label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" id="exampleInputIconRight"
                                    value="{{ request('search') }}" placeholder="Search" aria-label="Search">
                                <button type="submit" class="input-group-text">
                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                @if (request('search'))
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                        class="btn btn-outline-secondary ml-3" id="clear-search"> Clear</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">ID User</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Password</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data users yang dikirim dari Controller --}}
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <img src="{{ $user->profile_picture_url }}" width="50" height="50"
                                        style="object-fit:cover;border-radius:50%;">
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>{{ $user->password }}</td>
                                <td>
                                    <div class="d-flex">
                                        {{-- Tombol EDIT (CRUD UPDATE) --}}
                                        <a class="btn btn-sm btn-warning me-1" href="{{ route('user.edit', $user->id) }}">
                                            <i class="fa fa-edit"></i></a>

                                        {{-- Tombol HAPUS (CRUD DELETE) --}}
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-1"
                                                onclick="return confirm('Yakin ingin menghapus data {{ $user->name }}?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data users belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
