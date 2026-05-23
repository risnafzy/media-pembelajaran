<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkpdScore extends Model
{
    protected $fillable = [
        'user_id',
        'lkpd_case_id',
        'score',
        'feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(LkpdCase::class, 'lkpd_case_id');
    }
}