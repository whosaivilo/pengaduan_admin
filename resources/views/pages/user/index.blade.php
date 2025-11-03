@extends('layouts.app')
@section('title_page','Data User')
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
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">ID User</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
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
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->password }}</td>
                                <td>
                                    <div class="d-flex">
                                        {{-- Tombol EDIT (CRUD UPDATE) --}}
                                        <a class="btn btn-sm btn-warning me-1"
                                            href="{{ route('user.edit', $user->id) }}">
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
