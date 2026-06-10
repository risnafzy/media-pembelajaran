<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\LkpdCase;
use App\Models\LkpdScore;
use App\Models\LkpdAnswer;
use App\Models\LkpdPresentation;

class SiswaLkpdController extends Controller
{
    public function lkpdAwal($courseId)
    {
        return $this->index($courseId, 'awal');
    }

    public function lkpdLanjutan($courseId)
    {
        return $this->index($courseId, 'lanjutan');
    }

    public function index($courseId, $step = 'awal')
    {
        $course = Course::findOrFail($courseId);

        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);

        // ================= LOCK MATERI =================
        if ($step == 'lanjutan' && !$progress->materi) {
            return redirect()->route('siswa.course.materi', $course->id);
        }

        // ================= CASE =================
        $cases = LkpdCase::with([
            'questions' => function ($query) use ($step) {

                if ($step == 'awal') {
                    $query->whereBetween('no_soal', [1, 3]);
                } else {
                    $query->where('no_soal', '>=', 4);
                }

            },
            'questions.subQuestions'
        ])
        ->where('course_id', $course->id)
        ->get();

        // ================= SELECTED CASE =================
        $selectedCase = null;

        if ($progress->case_id) {
            $selectedCase = $cases->firstWhere('id', $progress->case_id);
        }

        // ================= JAWABAN =================
        $jawaban = collect();

        if ($selectedCase) {

            $jawaban = LkpdAnswer::where('student_id', auth()->id())

                ->where(function ($query) use ($selectedCase, $step) {

                    // ================= SOAL LANGSUNG =================
                    $query->whereHas('question', function ($q) use ($selectedCase, $step) {

                        $q->where('case_id', $selectedCase->id);

                        if ($step == 'awal') {
                            $q->whereBetween('no_soal', [1, 3]);
                        } else {
                            $q->where('no_soal', '>=', 4);
                        }

                    })

                    // ================= SUB SOAL =================
                    ->orWhereHas('subQuestion.question', function ($q) use ($selectedCase, $step) {

                        $q->where('case_id', $selectedCase->id);

                        if ($step == 'awal') {
                            $q->whereBetween('no_soal', [1, 3]);
                        } else {
                            $q->where('no_soal', '>=', 4);
                        }

                    });

                })

                ->get()

                ->mapWithKeys(function ($item) {

                    if ($item->sub_question_id) {
                        return [$item->sub_question_id => $item->jawaban];
                    }

                    return [$item->question_id => $item->jawaban];
                });
        }

        // ================= PROGRESS =================
        [$progressData, $percent, $unlock] = $this->progress($course);

        return view(
            $step == 'awal'
                ? 'siswa.lkpd.lkpd_awal'
                : 'siswa.lkpd.lkpd_lanjutan',
            [
                'course' => $course,
                'cases' => $cases,
                'selectedCase' => $selectedCase,
                'jawaban' => $jawaban,
                'progressData' => $progressData,
                'progressPercent' => $percent,
                'unlock' => $unlock,
                'step' => $step,
                'active' => $step == 'awal'
                    ? 'lkpd_awal'
                    : 'lkpd_lanjutan'
            ]
        );
    }

    // =====================================================
    // PROGRESS
    // =====================================================
    private function progress($course)
    {
        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);

        $done = collect([
            $progress->orientasi,
            $progress->lkpd1,
            $progress->materi,
            $progress->lkpd2,
            $progress->presentasi_done,
            $progress->refleksi
        ])->filter()->count();

        $percent = ($done / 6) * 100;

        $unlock = [
            'orientasi' => true,
            'lkpd' => $progress->orientasi,
            'materi' => $progress->lkpd1,
            'lkpd_lanjutan' => $progress->materi,
            'presentasi' => $progress->lkpd2,
            'refleksi' => $progress->presentasi_done
        ];

        return [$progress, $percent, $unlock];
    }

    // =====================================================
    // STORE
    // =====================================================
    public function store(Request $request, Course $course)
    {
        if (
            !$request->has('jawaban_sub')
            &&
            !$request->has('jawaban_q')
        ) {
            return back()->with('error', 'Tidak ada jawaban dikirim!');
        }

        // ================= SUB =================
        foreach ($request->jawaban_sub ?? [] as $subId => $isi) {

            if (!trim($isi)) continue;

            LkpdAnswer::updateOrCreate(
                [
                    'sub_question_id' => $subId,
                    'student_id' => auth()->id()
                ],
                [
                    'question_id' => null,
                    'jawaban' => $isi
                ]
            );
        }

        // ================= SOAL LANGSUNG =================
        foreach ($request->jawaban_q ?? [] as $qId => $isi) {

            if (!trim($isi)) continue;

            LkpdAnswer::updateOrCreate(
                [
                    'question_id' => $qId,
                    'student_id' => auth()->id()
                ],
                [
                    'sub_question_id' => null,
                    'jawaban' => $isi
                ]
            );
        }

        // ================= PROGRESS =================
        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);

        if (!$progress->lkpd1) {

            $progress->lkpd1 = true;
            $progress->save();

            return redirect()
                ->route('siswa.course.materi', $course->id)
                ->with('success', 'Jawaban LKPD Awal tersimpan');
        }

        if ($progress->materi && !$progress->lkpd2) {

            $progress->lkpd2 = true;
            $progress->save();

            return redirect()
                ->route('siswa.course.lkpd.presentasi', $course->id)
                ->with('success', 'Jawaban LKPD Lanjutan tersimpan');
        }

        return back()->with('success', 'Jawaban berhasil diperbarui');
    }

    // =====================================================
    // PRESENTASI
    // =====================================================
    public function presentasi($courseId)
    {
        $userId = auth()->id();

        $course = Course::findOrFail($courseId);

        $cases = LkpdCase::with('questions.subQuestions')
            ->where('course_id', $courseId)
            ->get();

        $progress = CourseProgress::where([
            'user_id' => $userId,
            'course_id' => $course->id
        ])->first();

        $case = null;

        if ($progress && $progress->case_id) {
            $case = $cases->firstWhere('id', $progress->case_id);
        }

        if (!$case) {
            return redirect()->route('siswa.course.lkpd.awal', $courseId);
        }


        [$progressData, $percent, $unlock] = $this->progress($course);

        $answers = LkpdAnswer::with(['subQuestion', 'question'])

            ->where('student_id', $userId)

            ->where(function ($query) use ($case) {

                $query->whereHas('question', function ($q) use ($case) {
                    $q->where('case_id', $case->id);
                })

                ->orWhereHas('subQuestion.question', function ($q) use ($case) {
                    $q->where('case_id', $case->id);
                });

            })

            ->get();



        $score = LkpdScore::where('user_id', $userId)
            ->where('lkpd_case_id', $case->id)
            ->first();

$presentation = LkpdPresentation::where([
    'user_id' => $userId,
    'lkpd_case_id' => $case->id
])->first();

if (!$presentation) {
    $presentation = LkpdPresentation::create([
        'user_id' => $userId,
        'lkpd_case_id' => $case->id
    ]);
}

        // cari kasus lain pada materi yang sama
        $otherCase = LkpdCase::where('course_id', $courseId)
            ->where('id', '!=', $case->id)
            ->first();

        $otherPresentations = collect();

        if ($otherCase) {

            $otherPresentations = LkpdPresentation::with([
                'user',
                'case'
            ])
            ->where('lkpd_case_id', $otherCase->id)
            ->where('user_id', '!=', $userId)
            ->whereNotNull('argumen_solusi')
            ->latest()
            ->get();

        }

        foreach ($otherPresentations as $otherPres) {
            $otherPres->lkpdAnswers = LkpdAnswer::with([
                'question',
                'subQuestion'
            ])
            ->where('student_id', $otherPres->user_id)
            ->where(function ($query) use ($otherPres) {
                $query->whereHas('question', function ($q) use ($otherPres) {
                    $q->where('case_id', $otherPres->lkpd_case_id);
                })
                ->orWhereHas('subQuestion.question', function ($q) use ($otherPres) {
                    $q->where('case_id', $otherPres->lkpd_case_id);
                });
            })
            ->get();
        }

foreach ($otherPresentations as $otherPresentation) {

    $otherPresentation->lkpdAnswers = LkpdAnswer::with([
        'question',
        'subQuestion'
    ])
    ->where('student_id', $otherPresentation->user_id)
    ->where(function ($query) use ($otherPresentation) {

        $query->whereHas('question', function ($q) use ($otherPresentation) {
            $q->where('case_id', $otherPresentation->lkpd_case_id);
        })

        ->orWhereHas('subQuestion.question', function ($q) use ($otherPresentation) {
            $q->where('case_id', $otherPresentation->lkpd_case_id);
        });

    })
    ->get();

}



        return view('siswa.presentasi.index', [
            'case' => $case,
            'answers' => $answers,
            'score' => $score,
            'progressData' => $progressData,
            'unlock' => $unlock,
            'active' => 'Presentasi',
            'progressPercent' => $percent,
            'presentation' => $presentation,
            'otherCase' => $otherCase,
            'otherPresentations' => $otherPresentations
        ]);
    }

    public function storePresentation(Request $request, $courseId)
    {
        // 1. Validasi dinamis berdasarkan form yang disubmit siswa
        $formType = $request->input('form_type', 'argumen');

        if ($formType === 'argumen') {
            $validated = $request->validate([
                'argumen_solusi' => 'required|string',
            ]);
        } else {
            $validated = $request->validate([
                'temuan_pola' => 'required|string',
            ]);
        }

        // 2. Ambil progress belajar siswa
        $progress = CourseProgress::where([
            'user_id' => auth()->id(),
            'course_id' => $courseId
        ])->first();

        if (!$progress || !$progress->case_id) {
            return back()->with('error', 'Kasus tidak ditemukan');
        }

        // 3. Ambil baris data presentasi yang sudah ada atau siapkan objek baru
        $presentation = LkpdPresentation::firstOrNew([
            'user_id' => auth()->id(),
            'lkpd_case_id' => $progress->case_id
        ]);

        // 4. Masukkan data ke kolom secara spesifik sesuai form yang aktif
        if ($formType === 'argumen') {
            $presentation->argumen_solusi = $validated['argumen_solusi'];
        } else {
            $presentation->temuan_pola = $validated['temuan_pola'];
        }

        // 5. Simpan perubahan ke database
        $presentation->save();

        // 6. Update progress alur pembelajaran siswa jika kedua bagian telah terisi
        if (!empty($presentation->argumen_solusi) && !empty($presentation->temuan_pola)) {
            $progress->presentasi_done = true;
            $progress->save();
        }

        return back()->with(
            'success',
            'Data presentasi berhasil diperbarui'
        );
    }


    // =====================================================
    // PILIH KASUS
    // =====================================================
    public function pilihKasus(Request $request, $course)
    {
        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course
        ]);

        // selalu update case
        $progress->case_id = $request->kasus;
        $progress->save();

        return redirect()->route('siswa.course.lkpd.awal', $course);
    }
}