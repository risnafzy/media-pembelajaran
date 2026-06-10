<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\LkpdAnswer;
use App\Models\LkpdScore;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Models\LkpdCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\LkpdPresentation;
use App\Models\MaterialAbstraction;

class NilaiController extends Controller
{

    // ========================
    // Rekap Nilai Pretest/Posttest
    // ========================
    public function index()
    {

        $nilai = DB::table('jawaban_siswa')
            ->join('users', 'jawaban_siswa.siswa_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name as nama',
                'jawaban_siswa.jenis',
                DB::raw('COUNT(jawaban_siswa.id) as total_soal'),
                DB::raw('SUM(jawaban_siswa.benar) as jumlah_benar'),
                DB::raw('(SUM(jawaban_siswa.benar) * 100.0 / COUNT(jawaban_siswa.id)) as nilai')
            )
            ->groupBy(
                'users.id',
                'users.name',
                'jawaban_siswa.jenis'
            )
            ->get();

        return view('guru.nilai.index', compact('nilai'));
    }

    public function detailPrePost($studentId, $jenis)
    {
        $student = User::findOrFail($studentId);

        $answers = DB::table('jawaban_siswa')
            ->join('bank_soal', 'jawaban_siswa.bank_soal_id', '=', 'bank_soal.id') // 🔥 FIX
            ->select(
                'bank_soal.pertanyaan',
                'bank_soal.jawaban_benar',
                'jawaban_siswa.jawaban',
                'jawaban_siswa.benar'
            )
            ->where('jawaban_siswa.siswa_id', $studentId)
            ->where('jawaban_siswa.jenis', $jenis)
            ->get();

        return view('guru.nilai.detail_prepost', compact('student', 'answers', 'jenis'));
    }






    //lkpd
    public function rekapLkpd()
    {
        $courses = Course::all();
        return view('guru.lkpd.rekap', compact('courses'));
    }

    public function show($courseId, $userId)
    {
    $user = User::findOrFail($userId);
    $cases = LkpdCase::with('questions.subQuestions')
        ->where('course_id', $courseId)
        ->get();
    $answers = LkpdAnswer::where('student_id', $userId)
        ->where(function ($query) use ($courseId) {

            $query->whereHas('subQuestion.question.case', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })

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

        $selectedCase = $cases->first();

        $existingScore = null;

        if ($selectedCase) {

            $existingScore = LkpdScore::where('user_id', $userId)
                ->where('lkpd_case_id', $selectedCase->id)
                ->first();
        }
        $presentation = null;

        if ($selectedCase) {

            $presentation = LkpdPresentation::where(
                'user_id',
                $userId
            )
            ->where(
                'lkpd_case_id',
                $selectedCase->id
            )
            ->first();

        }

        $abstraction = MaterialAbstraction::where([
            'user_id' => $userId,
            'course_id' => $courseId
        ])->first();


        return view('guru.lkpd.show', compact(
            'user',
            'cases',
            'answers',
            'existingScore',
            'presentation',
            'abstraction'

        ));
    }

    public function saveAbstraction(Request $request)
    {
        $request->validate([
            'abstraction_id' => 'required',
            'status_validasi' => 'required',
            'feedback_guru' => 'nullable'
        ]);

        $abstraction = MaterialAbstraction::findOrFail(
            $request->abstraction_id
        );

        $abstraction->update([
            'status_validasi' => $request->status_validasi,
            'feedback_guru' => $request->feedback_guru
        ]);

        return back()->with(
            'success',
            'Validasi abstraksi berhasil disimpan'
        );
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'answer_id' => 'required',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $answer = LkpdAnswer::findOrFail($request->answer_id);

        $caseId =
            $answer->question?->case_id
            ??
            optional($answer->subQuestion?->question)->case_id;

        LkpdScore::updateOrCreate(
            [
                'user_id' => $answer->student_id,
                'lkpd_case_id' => $caseId
            ],
            [
                'score' => $request->score,
                'feedback' => $request->feedback
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan');
    }

    public function export($jenis)
    {
        $namaFile = $jenis == 'pretest'
            ? 'Hasil_Pretest.xlsx'
            : 'Hasil_Posttest.xlsx';

        return Excel::download(
            new NilaiExport($jenis),
            $namaFile
        );
    }
}
