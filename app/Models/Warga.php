<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga'; // Nama tabel di database
    protected $primaryKey = 'warga_id'; // Nama Primary Key

    // Kolom yang dapat diisi melalui Mass Assignment
    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email'
    ];
}
