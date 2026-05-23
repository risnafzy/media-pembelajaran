<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseProgress;
// use App\Models\Orientasi;
use App\Models\JawabanPertanyaanOrientasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaOrientasiController extends Controller
{

public function show(Course $course)
{
    $orientasi = $course->orientasi()
        ->with(['pertanyaan' => function ($q) {
            $q->orderBy('urutan');
        }])
        ->first();

    // ambil jawaban siswa jika sudah ada
    $jawabanSiswa = JawabanPertanyaanOrientasi::where('user_id', Auth::id())
        ->whereIn(
            'pertanyaan_orientasi_id',
            optional($orientasi)->pertanyaan->pluck('id') ?? []
        )
        ->get()
        ->keyBy('pertanyaan_orientasi_id');

    // ambil progress
    [$progress, $percent, $unlock] = $this->progress($course);

    return view('siswa.orientasi.show', [
        'course' => $course,
        'active' => 'orientasi',
        'step' => 1,
        'progressPercent' => $percent,
        'unlock' => $unlock,
        'progress' => $progress,
        'jawabanSiswa' => $jawabanSiswa,
        'orientasi' => $orientasi
    ]);
}

    // ======================
    // SIMPAN JAWABAN
    // ======================

    public function simpanJawaban(Request $request, Course $course)
    {
    $request->validate([
        'jawaban' => 'required|array'
    ]);

    foreach ($request->jawaban as $pertanyaanId => $jawaban) {

        JawabanPertanyaanOrientasi::create([
            'user_id' => auth()->id(),
            'pertanyaan_orientasi_id' => $pertanyaanId,
            'jawaban' => $jawaban
        ]);
    }

    // update progress orientasi selesai
    CourseProgress::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ],
        [
            'orientasi' => true,
            'current_step' => 2
        ]
    );

    return redirect()
        ->route('siswa.course.lkpd.awal', $course->id)
        ->with('success', 'Jawaban orientasi berhasil disimpan');
    }

           private function progress($course)
    {

        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);
        /*
        menghitung progress
        total tahap = 5
        */

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
}
