<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\LkpdCase;
use App\Models\LkpdQuestion;
use App\Models\LkpdSubQuestion;
use App\Models\LkpdAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\RekapLkpdExport;
use Maatwebsite\Excel\Facades\Excel;

class LkpdController extends Controller
{
    // =========================
    // EXPORT
    // =========================
    public function export($courseId)
    {
        $course = Course::findOrFail($courseId);

        $fileName = 'Rekap-LKPD-' . $course->nama . '.xlsx';

        return Excel::download(new RekapLkpdExport($courseId), $fileName);
    }
    // =========================
    // CREATE
    // =========================
    public function create(Course $course)
    {
        $cases = LkpdCase::where('course_id', $course->id)
            ->with('questions.subQuestions')
            ->latest()
            ->get();

        return view('guru.lkpd.create', compact('course', 'cases'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'studi_kasus' => 'required|string',
            'questions' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $case = LkpdCase::create([
                'course_id' => $course->id,
                'judul' => $request->judul,
                'studi_kasus' => $request->studi_kasus,
                'created_by' => Auth::id()
            ]);

            foreach ($request->questions as $qData) {

                $question = LkpdQuestion::create([
                    'case_id' => $case->id,
                    'no_soal' => $qData['no_soal'],
                    'deskripsi' => $qData['deskripsi'] ?? null
                ]);

                // =========================
                // SUB OPSIONAL (FIX)
                // =========================
                if (!empty($qData['subs'])) {

                    foreach ($qData['subs'] as $subData) {

                        // skip jika kosong (quill kosong)
                        if (empty(trim(strip_tags($subData['pertanyaan'])))) {
                            continue;
                        }

                        LkpdSubQuestion::create([
                            'question_id' => $question->id,
                            'label' => $subData['label'],
                            'pertanyaan' => $subData['pertanyaan'],
                            'tipe_jawaban' => $subData['tipe_jawaban'] ?? 'text',
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('guru.course.show', $course->id)
                ->with('success', 'LKPD berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // SHOW (LIHAT & NILAI)
    // =========================
    public function show($courseId, $userId)
    {
        $course = Course::findOrFail($courseId);

        $answers = LkpdAnswer::where('student_id', $userId)
            ->where(function ($query) use ($courseId) {

                // LIST (sub_question)
                $query->whereHas('subQuestion.question.case', function ($q) use ($courseId) {
                    $q->where('course_id', $courseId);
                })

                // TUPLE (question langsung)
                ->orWhereHas('question.case', function ($q) use ($courseId) {
                    $q->where('course_id', $courseId);
                });

            })
            ->with([
                'subQuestion.question',
                'question',
                'student'
            ])
            ->get();

        $student = $answers->first()->student ?? null;

        $totalScore = $answers->sum('score');

        return view('guru.nilai.show', compact(
            'course',
            'answers',
            'student',
            'totalScore'
        ));
    }

    // =========================
    // SAVE SCORE
    // =========================
    public function saveScore(Request $request)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|integer|min:0|max:100'
        ]);

        foreach ($request->scores as $answerId => $score) {

            LkpdAnswer::where('id', $answerId)
                ->update([
                    'score' => $score
                ]);
        }

        return back()->with('success', 'Nilai berhasil disimpan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $case = LkpdCase::with('questions.subQuestions')->findOrFail($id);
        $course = Course::findOrFail($case->course_id);

        return view('guru.lkpd.edit', compact('case', 'course'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'studi_kasus' => 'required',
            'questions' => 'required|array'
        ]);

        $case = LkpdCase::findOrFail($id);

        $case->update([
            'judul' => $request->judul,
            'studi_kasus' => $request->studi_kasus
        ]);

        // hapus lama
        foreach ($case->questions as $q) {
            $q->subQuestions()->delete();
        }
        $case->questions()->delete();

        // insert ulang
        foreach ($request->questions as $qData) {

            $question = LkpdQuestion::create([
                'case_id' => $case->id,
                'no_soal' => $qData['no_soal'],
                'deskripsi' => $qData['deskripsi'] ?? null
            ]);

            // =========================
            // SUB OPSIONAL (FIX)
            // =========================
            if (!empty($qData['subs'])) {

                foreach ($qData['subs'] as $sub) {

                    if (empty(trim(strip_tags($sub['pertanyaan'])))) {
                        continue;
                    }

                    LkpdSubQuestion::create([
                        'question_id' => $question->id,
                        'label' => $sub['label'],
                        'pertanyaan' => $sub['pertanyaan'],
                        'tipe_jawaban' => $sub['tipe_jawaban'] ?? 'text'
                    ]);
                }
            }
        }

        return redirect()
            ->route('guru.course.show', $case->course_id)
            ->with('success', 'LKPD berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $case = LkpdCase::findOrFail($id);
        $case->delete();

        return back()->with('success', 'LKPD berhasil dihapus');
    }
}
