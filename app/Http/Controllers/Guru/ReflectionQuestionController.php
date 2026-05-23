<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReflectionQuestion;
use App\Models\Course;
use App\Models\ReflectionAnswer;

class ReflectionQuestionController extends Controller
{

    public function index()
    {
    $courses = Course::with(['reflectionQuestions.answers.student'])->get();

    return view('guru.reflection.index',[
        'courses'=>$courses
    ]);
    }

    public function rekapRefleksi()
    {
            $courses = Course::with(['reflectionQuestions.answers.student'])->get();

            return view('guru.reflection.index', compact('courses'));
            }

            public function showRekapRefleksi($course, $user)
            {
            $course = Course::findOrFail($course);

            $answers = ReflectionAnswer::with('question')
                ->where('student_id',$user)
                ->whereHas('question', function($q) use ($course){
                    $q->where('course_id',$course->id);
                })
                ->get();

            return view('guru.reflection.show',[
                'course'=>$course,
                'answers'=>$answers
            ]);
    }

    public function create($course_id)
    {
        return view('guru.reflection.create', [
            'course_id' => $course_id
        ]);
    }
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kategori' => 'required|in:evaluasi,refleksi'
        ]);

        ReflectionQuestion::create([
            'course_id' => $course_id,
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('guru.course.show', $course_id)
            ->with('success','Pertanyaan refleksi berhasil ditambahkan');
    }

    public function update(Request $request, $course_id, $question_id)
    {
    $request->validate([
        'pertanyaan' => 'required|string',
        'kategori' => 'required|in:evaluasi,refleksi'
    ]);

    $question = ReflectionQuestion::findOrFail($question_id);

    $question->update([
        'pertanyaan' => $request->pertanyaan,
        'kategori' => $request->kategori
    ]);

    return redirect()
        ->route('guru.course.show', $course_id)
        ->with('success', 'Pertanyaan berhasil diupdate');
    }


    public function edit($course_id, $question_id)
    {
        $question = ReflectionQuestion::findOrFail($question_id);

        return view('guru.reflection.edit', compact('question','course_id'));
    }

    public function answers()
    {
        $questions = ReflectionQuestion::with('answers.student')->get();

        return view('guru.reflection.answer', compact('questions'));
    }

    public function destroy($courseId, $id)
{
    $question = ReflectionQuestion::findOrFail($id);
    $question->delete();

    return redirect()->back()->with('success', 'Pertanyaan refleksi berhasil dihapus');
}
}
