<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_option_id',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // relasi ke option
    public function option()
    {
        return $this->belongsTo(AnswerOption::class, 'answer_option_id');
    }
}