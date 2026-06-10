<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrientasiFeedback extends Model
{
    protected $table = 'orientasi_feedback';

    protected $fillable = [
        'user_id',
        'course_id',
        'komentar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
