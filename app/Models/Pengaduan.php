<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'pengaduan_id';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nomor_tiket',
        'warga_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'status',
        'lokasi_text',
        'rt',
        'rw',
        'lampiran_bukti'
    ];

   // Relasi wajib (Dipanggil di DashboardController)
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id','warga_id');
    }



}
