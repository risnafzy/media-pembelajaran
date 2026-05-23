<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Materi;
use App\Models\Orientasi;
use App\Models\ReflectionQuestion;
use App\Models\LkpdCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    // =========================
    // LIST COURSE
    // =========================
    public function index()
    {
        $courses = Course::where('guru_id', Auth::id())->get();

        return view('guru.course.index', compact('courses'));
    }


    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('guru.course.create');
    }


    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        Course::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'guru_id' => Auth::id()
        ]);

        return redirect()
            ->route('guru.course.index')
            ->with('success', 'Course berhasil dibuat');
    }


    // =========================
    // DETAIL COURSE
    // =========================
    public function show($id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($id);

        // materi
        $materis = Materi::where('course_id', $course->id)->get();

        // LKPD baru (case-based)
        $cases = LkpdCase::with('questions.subQuestions')
            ->where('course_id', $course->id)
            ->get();

        // orientasi
        $orientasi = Orientasi::where('course_id', $course->id)->first();

        // refleksi
        $reflectionQuestions = ReflectionQuestion::where('course_id', $course->id)->get();

        return view('guru.course.show', compact(
            'course',
            'materis',
            'cases', // ✅ FIX DISINI
            'orientasi',
            'reflectionQuestions'
        ));
    }


    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($id);

        return view('guru.course.edit', compact('course'));
    }


    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $course->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('guru.course.index')
            ->with('success', 'Course berhasil diupdate');
    }


    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($id);

        $course->delete();

        return back()->with('success', 'Course berhasil dihapus');
    }
}
