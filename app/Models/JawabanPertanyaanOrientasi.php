<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPertanyaanOrientasi extends Model
{
    protected $fillable = [
        'user_id',
        'pertanyaan_orientasi_id',
        'jawaban'
    ];

public function user()
{
    return $this->belongsTo(User::class);
}

public function pertanyaan()
{
    return $this->belongsTo(PertanyaanOrientasi::class,'pertanyaan_orientasi_id');
}
}