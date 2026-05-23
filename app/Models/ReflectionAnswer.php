<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReflectionAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'student_id',
        'jawaban'
    ];

    public function student()
    {
    return $this->belongsTo(User::class, 'student_id');
    }

    public function question()
    {
    return $this->belongsTo(ReflectionQuestion::class, 'question_id');
    }
}
