<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $fillable =
    [
        'course_id',
        'judul',
        'pertemuan_ke'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function orientasi()
    {
        return $this->hasOne(OrientasiMasalah::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function lkpd()
    {
        return $this->hasOne(Lkpd::class);
    }

    public function eksplorasi()
    {
        return $this->hasMany(EksplorasiKode::class);
    }

    public function refleksi()
    {
        return $this->hasMany(Refleksi::class);
    }
}
