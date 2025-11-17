<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table      = 'media';
    protected $primaryKey = 'media_id';

    protected $fillable = [
        'pengaduan_id',
        'path_file',
        'tipe_file',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }
}
