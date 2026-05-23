<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orientasi extends Model
{

    protected $fillable =
    [
        'course_id',
        'tujuan',
        'isi'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function orientasi()
    {
        return $this->hasOne(Orientasi::class);
    }

    public function pertanyaan()
    {
    return $this->hasMany(PertanyaanOrientasi::class);
    }
}
