<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkpdAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'sub_question_id',
        'student_id',
        'jawaban'
    ];

    // ke sub soal
    public function subQuestion()
    {
        return $this->belongsTo(LkpdSubQuestion::class, 'sub_question_id');
    }

    // ke siswa
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function question()
    {
        return $this->belongsTo(LkpdQuestion::class, 'question_id');
    }
}
