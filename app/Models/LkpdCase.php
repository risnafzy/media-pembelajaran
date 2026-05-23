<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkpdCase extends Model
{
    protected $fillable = [
        'course_id',
        'judul',
        'studi_kasus',
        'created_by'
    ];

    // relasi ke course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // relasi ke guru
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relasi ke soal
    public function questions()
    {
        return $this->hasMany(LkpdQuestion::class, 'case_id')->orderBy('no_soal');
    }

    //score
    public function score() {
        return $this->hasOne(LkpdScore::class);
    }


}