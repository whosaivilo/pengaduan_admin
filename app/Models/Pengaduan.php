<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    protected $table      = 'pengaduan';
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
    ];

    // Relasi wajib (Dipanggil di DashboardController)
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    public function penilaianLayanan()
    {
        return $this->hasOne(PenilaianLayanan::class, 'pengaduan_id', 'pengaduan_id');
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id', 'kategori_id');
    }
    public function media()
    {
        return $this->hasMany(
            Media::class, 'ref_id', 'pengaduan_id')
            ->where('ref_table', 'pengaduan')
            ->orderBy('sort_order');

    }

    public function tindak_lanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'pengaduan_id', 'pengaduan_id')
            ->orderBy('tindak_id');
    }

    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }
    public function scopeSearch($query, $request, array $columns)
    {
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    if ($column == 'kategori') {
                        // Search di relasi kategori
                        $q->orWhereHas('kategori', function ($q2) use ($search) {
                            $q2->where('nama', 'LIKE', "%$search%");
                        });
                    } else {
                        $q->orWhere($column, 'LIKE', "%$search%");
                    }
                }
            });
        }
    }

}
