<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{

    // ================= PRETEST =================

    public function pretest()
    {
        $data = JawabanSiswa::where('siswa_id', Auth::id())
                    ->where('jenis','pretest')
                    ->get();

        $sudah = $data->count() > 0;

        $total = $data->count();
        $benar = $data->where('benar',1)->count();
        $nilai = $total > 0 ? round(($benar/$total)*100) : 0;

        return view('siswa.ujian.show', [
            'jenis' => 'pretest',
            'sudah' => $sudah,
            'nilai' => $nilai
        ]);
    }

    public function startPretest()
    {
        // cegah ulang
        $cek = JawabanSiswa::where('siswa_id', Auth::id())
                ->where('jenis','pretest')
                ->exists();

        if ($cek) {
            return redirect('/siswa/pretest/hasil');
        }

        $soal = BankSoal::where('jenis','pretest')->get();

        return view('siswa.ujian.pretest', compact('soal'));
    }

    public function submitPretest(Request $request)
    {
        $userId = Auth::id();

        foreach($request->jawaban as $soal_id => $jawaban){

            $soal = BankSoal::find($soal_id);

            $benar = $soal->jawaban_benar == $jawaban;

            // 🔥 FIX: pakai updateOrCreate biar tidak double
            JawabanSiswa::updateOrCreate(
                [
                    'siswa_id' => $userId,
                    'bank_soal_id' => $soal_id,
                    'jenis' => 'pretest'
                ],
                [
                    'jawaban' => $jawaban,
                    'benar' => $benar
                ]
            );
        }

        // 🔥 langsung ke hasil
        return redirect('/siswa/pretest/hasil');
    }



    // ================= POSTTEST =================

    public function posttest()
    {
        $data = JawabanSiswa::where('siswa_id', Auth::id())
                    ->where('jenis','posttest')
                    ->get();

        $sudah = $data->count() > 0;

        $total = $data->count();
        $benar = $data->where('benar',1)->count();
        $nilai = $total > 0 ? round(($benar/$total)*100) : 0;

        return view('siswa.ujian.show', [
            'jenis' => 'posttest',
            'sudah' => $sudah,
            'nilai' => $nilai
        ]);
    }

    public function startPosttest()
    {
        // cegah ulang
        $cek = JawabanSiswa::where('siswa_id', Auth::id())
                ->where('jenis','posttest')
                ->exists();

        if ($cek) {
            return redirect('/siswa/posttest/hasil');
        }

        $soal = BankSoal::where('jenis','posttest')->get();

        return view('siswa.ujian.posttest', compact('soal'));
    }

    public function submitPosttest(Request $request)
    {
        $userId = Auth::id();

        foreach($request->jawaban as $soal_id => $jawaban){

            $soal = BankSoal::find($soal_id);

            $benar = $soal->jawaban_benar == $jawaban;

            // 🔥 FIX: tidak double insert
            JawabanSiswa::updateOrCreate(
                [
                    'siswa_id' => $userId,
                    'bank_soal_id' => $soal_id,
                    'jenis' => 'posttest'
                ],
                [
                    'jawaban' => $jawaban,
                    'benar' => $benar
                ]
            );
        }

        // 🔥 langsung tampil hasil
        return redirect('/siswa/posttest/hasil');
    }



    public function hasil()
    {
        $jenis = request()->segment(2); // ambil dari URL (pretest/posttest)

        $data = JawabanSiswa::with('soal')
            ->where('siswa_id', Auth::id())
            ->where('jenis', $jenis)
            ->get();

        $total = $data->count();
        $benar = $data->where('benar', 1)->count();
        $nilai = $total > 0 ? round(($benar/$total)*100) : 0;

        return view('siswa.ujian.hasil', compact('data','nilai','jenis'));
    }

}
