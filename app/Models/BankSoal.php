<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    protected $table = 'bank_soal';

    protected $fillable = [

        'guru_id',
        'jenis',
        'pertanyaan',

        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',

        'jawaban_benar'

    ];

}