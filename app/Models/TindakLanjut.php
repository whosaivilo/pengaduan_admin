<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TindakLanjut extends Model
{
    protected $table      = 'tindak_lanjut';
    protected $primaryKey = 'tindak_id';

    protected $fillable = ['pengaduan_id', 'petugas', 'aksi', 'catatan'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'penggaduan_id','pengaduan_id',  'pengaduan_id', 'pengaduan_id');
    }


}
