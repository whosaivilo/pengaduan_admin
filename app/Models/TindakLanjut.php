<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table      = 'tindak_lanjut';
    protected $primaryKey = 'tindak_id';

    // Isi fillable sesuai kolom yang ada di tabel
    protected $fillable = ['pengaduan_id', 'petugas', 'aksi', 'catatan'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }

    // Relasi Polimorfik (Foto saat tindak lanjut)
    public function media()
    {
        return $this->morphMany(Media::class, 'reference', 'ref_table', 'ref_id');
    }
}
