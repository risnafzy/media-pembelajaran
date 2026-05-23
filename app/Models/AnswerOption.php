<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    protected $fillable = [
        'question_id',
        'option',
        'is_correct',
    ];

    // relasi ke question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // relasi ke jawaban siswa
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}