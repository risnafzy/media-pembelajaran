<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseProgress;


class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::all();

        return view('course.index',compact('courses'));
    }


    public function show(Course $course)
    {
        $progress = CourseProgress::firstOrCreate([
        'user_id'=>Auth::id(),
        'course_id'=>$course->id
        ]);


        return view('course.show',compact('course','progress'));
    }

    private function progress($course)
    {
        $progress = CourseProgress::firstOrCreate([
            'user_id'=>auth()->id(),
            'course_id'=>$course->id
        ]);

        $done = collect([
            $progress->orientasi,
            $progress->lkpd1,
            $progress->materi,
            $progress->lkpd2,
            $progress->code,
            $progress->lkpd3,
            $progress->presentasi_done,
            $progress->refleksi
        ])->filter()->count();

        $percent = ($done / 6) * 100;

        $unlock = [
            'orientasi'=>true,
            'lkpd1'=>$progress->orientasi,
            'materi'=>$progress->lkpd1,
            'lkpd2'=>$progress->materi,
            'code'=>$progress->lkpd2,
            'lkpd3'=>$progress->code,
            'refleksi'=>$progress->lkpd3
        ];

        return [$progress,$percent,$unlock];
    }

}