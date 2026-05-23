<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanOrientasi extends Model
{
    protected $fillable = [
        'orientasi_id',
        'pertanyaan',
        'tipe',
        'level_kognitif',
        'urutan'
    ];

    public function orientasi()
    {
        return $this->belongsTo(Orientasi::class);
    }

    public function jawaban()
{
    return $this->hasMany(JawabanPertanyaanOrientasi::class, 'pertanyaan_orientasi_id');
}
}