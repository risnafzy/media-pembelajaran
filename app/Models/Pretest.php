<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    protected $fillable = [
        'title',
    ];

    // relasi ke tabel questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
