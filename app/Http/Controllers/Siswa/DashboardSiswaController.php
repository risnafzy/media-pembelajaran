<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\JawabanSiswa;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $courseAktif = Course::count();

        $pretest = JawabanSiswa::where('siswa_id', auth()->id())
                    ->where('jenis','pretest')
                    ->exists() ? 1 : 0;

        $posttest = JawabanSiswa::where('siswa_id', auth()->id())
                    ->where('jenis','posttest')
                    ->exists() ? 1 : 0;

        $tugas = ($pretest + $posttest) . '/2';

        $progressData = CourseProgress::where('user_id', auth()->id())->get();

$totalSelesai = 0;
$totalTahap = 0;

foreach ($progressData as $item) {

    $tahapan = [
        $item->orientasi,
        $item->lkpd1,
        $item->materi,
        $item->lkpd2,
        $item->code,
        $item->lkpd3,
        $item->refleksi
    ];

    $totalTahap += count($tahapan);

    foreach ($tahapan as $status) {
        if ($status) {
            $totalSelesai++;
        }
    }
}

$progress = $totalTahap > 0
    ? round(($totalSelesai / $totalTahap) * 100)
    : 0;

        // rata-rata nilai siswa
        $totalSoalPretest = \App\Models\BankSoal::where('jenis','pretest')->count();
        $totalSoalPosttest = \App\Models\BankSoal::where('jenis','posttest')->count();

        $nilaiPretest = JawabanSiswa::where('siswa_id', auth()->id())
                            ->where('jenis','pretest')
                            ->avg('benar');

        $nilaiPosttest = JawabanSiswa::where('siswa_id', auth()->id())
                            ->where('jenis','posttest')
                            ->avg('benar');

        $skorPretest = $totalSoalPretest > 0
            ? ($nilaiPretest / $totalSoalPretest) * 100
            : 0;

        $skorPosttest = $totalSoalPosttest > 0
            ? ($nilaiPosttest / $totalSoalPosttest) * 100
            : 0;

        $rataRataNilai = round(($skorPretest + $skorPosttest) / 2, 1);

        // rata-rata nilai
        $rataRataNilai = round(($skorPretest + $skorPosttest) / 2, 1);

        // peningkatan nilai siswa
        $peningkatan = round(
            $skorPosttest - $skorPretest,
        1);

        return view('siswa.dashboard.dashboard-siswa', compact(
            'courseAktif',
            'progress',
            'tugas',
            'rataRataNilai',
            'peningkatan'
        ));
    }
}