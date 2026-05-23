<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseProgress;

class SiswaCodeRunnerController extends Controller
{

    public function index($course)
    {
        $course = Course::findOrFail($course);

        [$progress, $percent, $unlock] = $this->progress($course);

        return view('siswa.code-runner.index', [
            'course' => $course,
            'progress' => $progress,
            'progressPercent' => $percent,
            'unlock' => $unlock,
            'active' => 'code',
            'step' => 4
        ]);
    }


    private function progress($course)
    {

        $progress = CourseProgress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id
        ]);

        $done = collect([
            $progress->orientasi_done,
            $progress->lkpd1_done,
            $progress->materi_done,
            $progress->code_done,
            $progress->refleksi_done
        ])->filter()->count();

        $percent = ($done / 5) * 100;

        $unlock = [
            'orientasi' => true,
            'lkpd' => $progress->orientasi_done,
            'materi' => $progress->lkpd1_done,
            'code' => $progress->materi_done,
            'refleksi' => $progress->lkpd2_done
        ];

        return [$progress, $percent, $unlock];
    }
}