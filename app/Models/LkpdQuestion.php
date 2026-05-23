<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkpdQuestion extends Model
{
    protected $fillable = [
        'case_id',
        'no_soal',
        'deskripsi'
    ];

    // ke studi kasus
    public function case()
    {
        return $this->belongsTo(LkpdCase::class, 'case_id');
    }

    // ke sub soal
    public function subQuestions()
    {
        return $this->hasMany(LkpdSubQuestion::class, 'question_id')
                    ->orderBy('label');
    }
}