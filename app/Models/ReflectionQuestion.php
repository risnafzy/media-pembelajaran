<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReflectionQuestion extends Model
{
    protected $fillable = [
        'course_id',
        'pertanyaan',
        'kategori'
    ];

    public function answers()
    {
    return $this->hasMany(ReflectionAnswer::class, 'question_id');
    }
}