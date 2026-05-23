<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswa';

    protected $fillable = [
        'siswa_id',
        'bank_soal_id',
        'jenis',
        'jawaban',
        'benar'
    ];

    public function soal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_soal_id');
    }
}