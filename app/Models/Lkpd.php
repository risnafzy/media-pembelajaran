<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lkpd extends Model
{

    protected $table = 'lkpd';

    protected $fillable = [
        'course_id',
        'tahapan_pbl',
        'indikator_ct',
        'pertanyaan',
        'urutan'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanLkpd::class,'lkpd_id');
    }

}
