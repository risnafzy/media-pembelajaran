<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReflectionQuestion;

class Course extends Model
{
    protected $fillable = ['nama','deskripsi','guru_id'];

    public function orientasi()
    {
    return $this->hasOne(Orientasi::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function lkpd()
    {
        return $this->hasMany(Lkpd::class,'course_id');
    }

    public function reflectionQuestions()
    {
    return $this->hasMany(ReflectionQuestion::class, 'course_id');
    }

    public function students()
{
    return $this->belongsToMany(User::class,'course_user','course_id','user_id');
}


}
