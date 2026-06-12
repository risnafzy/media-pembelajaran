<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Materi;
use App\Models\LkpdAnswer;
use App\Models\LkpdScore;
use App\Models\JawabanSiswa;
use App\Models\Course;
use App\Models\BankSoal;
use App\Models\CourseProgress;

class DashboardGuruController extends Controller
{
    public function index()
    {

        // total siswa
        $totalSiswa = User::where('role','siswa')->count();

        // total materi
        $totalMateri = Materi::count();

        // LKPD yang belum dinilai
        $tugasPending = LkpdAnswer::distinct('student_id')->count('student_id')
                - LkpdScore::count();

        // ======================
        // Rata-rata Pretest
        // ======================

        $totalSoalPretest = BankSoal::where('jenis','pretest')->count();

        $avgPretest = JawabanSiswa::where('jenis','pretest')
                        ->avg('benar');

        $rataPretest = $totalSoalPretest > 0
            ? round(($avgPretest / $totalSoalPretest) * 100,1)
            : 0;


        // ======================
        // Rata-rata Posttest
        // ======================

        $totalSoalPosttest = BankSoal::where('jenis','posttest')->count();

        $avgPosttest = JawabanSiswa::where('jenis','posttest')
                        ->avg('benar');

        $rataPosttest = $totalSoalPosttest > 0
            ? round(($avgPosttest / $totalSoalPosttest) * 100,1)
            : 0;


        // ======================
        // Peningkatan
        // ======================

        $peningkatan = round(
            $rataPosttest - $rataPretest,
        1);

        // aktivitas siswa terbaru
      $aktivitas = CourseProgress::with('user', 'course')
   ->where(function ($query) {
    $query->where('orientasi', true)
          ->orWhere('lkpd1', true)
          ->orWhere('materi', true)
          ->orWhere('lkpd2', true)
          ->orWhere('code', true)
          ->orWhere('lkpd3', true)
          ->orWhere('refleksi', true);
})
    ->latest()
    ->take(5)
    ->get();

        // course yang dikelola
        $managedCourses = Course::withCount('materi')->get();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'totalMateri',
            'tugasPending',
            'rataPretest',
            'rataPosttest',
            'peningkatan',
            'managedCourses',
            'aktivitas'
        ));
    }
}