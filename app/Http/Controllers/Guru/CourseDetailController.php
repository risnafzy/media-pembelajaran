<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Orientasi;
use App\Models\Lkpd;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use App\Models\ReflectionQuestion;

class CourseDetailController extends Controller
{

    public function show($id)
    {

        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($id);

        $orientasi = Orientasi::where('course_id',$id)->first();

        $lkpds = Lkpd::where('course_id',$id)->get();

        $materis = Materi::where('course_id',$id)->get();

        $reflectionQuestions = ReflectionQuestion::where('course_id',$course->id)->get();

        return view('guru.course.show', compact(
            'course',
            'orientasi',
            'lkpds',
            'materis',
            'reflectionQuestions'
        ));

    }

}
