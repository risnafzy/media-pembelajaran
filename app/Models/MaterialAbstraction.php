<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAbstraction extends Model
{
    protected $fillable = [
    'user_id',
    'course_id',
    'konsep',
    'bagian_kasus',
    'informasi_tidak_relevan',
    'status_validasi',
    'feedback_guru'
];
}
