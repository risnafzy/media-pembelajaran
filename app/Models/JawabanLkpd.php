<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanLkpd extends Model
{

    protected $table = 'lkpd_jawaban';

    protected $fillable = [
        'lkpd_id',
        'user_id',
        'jawaban'
    ];

    public function lkpd()
    {
        return $this->belongsTo(Lkpd::class,'lkpd_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
