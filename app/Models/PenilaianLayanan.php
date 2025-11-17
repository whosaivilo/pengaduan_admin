<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenilaiLayanan extends Model
{
    protected $table = 'penilai_layanan';
    protected $primaryKey = 'penilaian_id';

    protected $fillable = ['pengaduan_id', 'rating', 'komentar'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }
}
