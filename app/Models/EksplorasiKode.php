<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EksplorasiKode extends Model
{
    protected $fillable =
    [
        'pertemuan_id',
        'judul',
        'deskripsi',
        'starter_code'
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }
}