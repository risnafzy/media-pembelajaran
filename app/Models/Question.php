<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'pretest_id',
        'question',
    ];

    // relasi ke pretest
    public function pretest()
    {
        return $this->belongsTo(Pretest::class);
    }

    // relasi ke pilihan jawaban
    public function options()
    {
        return $this->hasMany(AnswerOption::class);
    }

    // relasi ke jawaban siswa
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}