<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table      = 'tindak_lanjut';
    protected $primaryKey = 'tindak_id';

    protected $fillable = ['pengaduan_id', 'petugas', 'aksi', 'catatan', 'lampiran_bukti'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'tindak_id')
        ->where('ref_table', 'tindak_lanjut')
        ->orderBy('sort_order');
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
                    // Pastikan kolom ada di tabel tindak_lanjut
                    $q->orWhere($column, 'LIKE', "%$search%");
                }
            });
        }

        return $query;
    }

}
