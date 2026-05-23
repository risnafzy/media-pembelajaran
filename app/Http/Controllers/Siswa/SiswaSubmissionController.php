<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaSubmissionController extends Controller
{

    public function create(Course $course)
    {
        return view('siswa.submission.create', compact('course'));
    }


    public function store(Request $request, Course $course)
    {
        $request->validate([
            'jawaban' => 'required'
        ]);

        Submission::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'jawaban' => $request->jawaban
        ]);

        return redirect()
            ->route('siswa.course.show', $course->id)
            ->with('success', 'Jawaban berhasil dikirim');
    }

}
