<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Materi;
use App\Models\CourseProgress;
use App\Models\MaterialAbstraction;
use Illuminate\Http\Request;

class SiswaMateriController extends Controller
{
    public function index($course, $step = 1)
    {
        $materis = Materi::where('course_id', $course)
                    ->orderBy('id')
                    ->get();

        $materi = $materis[$step - 1] ?? null;

        $courseModel = Course::findOrFail($course);

        [$progress,$percent,$unlock] = $this->progress($courseModel);

        $abstraction = MaterialAbstraction::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $courseModel->id
        ]);

        $abstractionCompleted =
        !empty($abstraction->konsep)
        && !empty($abstraction->bagian_kasus)
        && !empty($abstraction->informasi_tidak_relevan);

        return view('siswa.materi.index', [
            'course' => $courseModel,
            'materi' => $materi,
            'step' => $step,
            'total' => $materis->count(),
            'active' =>'materi',
            'progressPercent' => $percent,
            'unlock' => $unlock,
            'progress' => $progress,
            'abstractionCompleted' => $abstractionCompleted,
            'abstraction' => $abstraction
        ]);
    }

    public function simpanAbstraksi(Request $request, Course $course)
{
    $request->validate([
        'konsep' => 'required',
        'bagian_kasus' => 'required',
        'informasi_tidak_relevan' => 'required'
    ]);

    MaterialAbstraction::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ],
        [
            'konsep' => $request->konsep,
            'bagian_kasus' => $request->bagian_kasus,
            'informasi_tidak_relevan' => $request->informasi_tidak_relevan
        ]
    );

    return back()->with('success','Jawaban abstraksi tersimpan');
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
            $progress->orientasi ,
            $progress->lkpd1 ,
            $progress->materi ,
            $progress->lkpd2 ,
            $progress->presentasi_done ,
            $progress->refleksi
        ])->filter()->count();

        $percent = ($done / 6) * 100;
        /*
        unlock menu sidebar
        */

        $unlock = [
            'orientasi' => true,
            'lkpd' => $progress->orientasi ,
            'materi' => $progress->lkpd1 ,
            'lkpd_lanjutan' => $progress->materi ,
            'presentasi' => $progress->lkpd2 ,
            'refleksi' => $progress->presentasi_done
        ];

        return [$progress, $percent, $unlock];
    }

    public function selesai(Course $course)
    {
        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);

        $progress->materi  = 1;
        $progress->save();

        $abstraction = MaterialAbstraction::where([
    'user_id' => auth()->id(),
    'course_id' => $course->id
    ])->first();

    if (
        !$abstraction ||
        blank($abstraction->konsep) ||
        blank($abstraction->bagian_kasus) ||
        blank($abstraction->informasi_tidak_relevan)
    ) {
        return back()->with(
            'error',
            'Lengkapi bagian Hubungkan Materi dengan Kasus terlebih dahulu.'
        );
    }

        return redirect()->route('siswa.course.lkpd.lanjutan', [$course->id, 2]);
    }

}
