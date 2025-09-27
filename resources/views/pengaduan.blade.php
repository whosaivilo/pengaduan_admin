<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengaduan</title>
</head>
<body>
    <h1>Daftar Pengaduan Warga</h1>

    @if(count($pengaduan) > 0)
        <ul>
            {{-- Looping untuk semua data --}}
            @foreach($pengaduan as $item)
                <li>
                    <strong>{{ $item['judul'] }}</strong>
                    | Status: {{ $item['status'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Belum ada pengaduan.</p>
    @endif
</body>
</html>
