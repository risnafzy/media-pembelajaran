<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseProgress;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SiswaCourseController extends Controller
{

    public function index()
    {
        // ambil semua course
        $courses = Course::all();

        return view('siswa.course.index', compact('courses'));
    }


public function show(Course $course)
{
    // load semua relasi yang dibutuhkan
    $course->load([
        'orientasi',
        'materi'
    ]);

    $progress = CourseProgress::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'course_id' => $course->id
        ]
    );

    return view('siswa.course.show', compact('course','progress'));
}



}