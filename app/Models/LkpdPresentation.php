<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LkpdCase;

class LkpdPresentation extends Model
{
    protected $fillable = [
        'user_id',
        'lkpd_case_id',
        'argumen_solusi',
        'temuan_pola'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(
            LkpdCase::class,
            'lkpd_case_id'
        );
    }

}
