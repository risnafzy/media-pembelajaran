<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkpdSubQuestion extends Model
{
    protected $fillable = [
        'question_id',
        'label',
        'pertanyaan',
        'tipe_jawaban',
    ];

    // ke nomor soal
    public function question()
    {
        return $this->belongsTo(LkpdQuestion::class, 'question_id');
    }

    // ke jawaban siswa
    public function answers()
    {
        return $this->hasMany(LkpdAnswer::class, 'sub_question_id');
    }
}
