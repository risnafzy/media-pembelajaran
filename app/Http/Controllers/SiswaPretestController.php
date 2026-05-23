<?php

namespace App\Http\Controllers;

use App\Models\Pretest;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaPretestController extends Controller
{
    // tampilkan halaman pretest
    public function index()
    {
        // cek apakah siswa sudah pernah mengerjakan
        $sudah = Answer::where('user_id', Auth::id())->exists();

        if ($sudah)
        {
            return redirect()->route('siswa.pretest.done');
        }

        // ambil pretest beserta soal
        $pretest = Pretest::with('questions.options')->first();

        // jika belum ada pretest di database
        if (!$pretest)
        {
            return view('siswa.pretest.done');
        }

        return view('siswa.pretest.index', compact('pretest'));
    }


    // simpan jawaban siswa
    public function submit(Request $request)
    {
        // validasi
        $request->validate([
            'answers' => 'required|array'
        ]);

        foreach ($request->answers as $question_id => $answer_option_id)
        {
            Answer::create([
                'user_id' => Auth::id(),
                'question_id' => $question_id,
                'answer_option_id' => $answer_option_id,
            ]);
        }

        return redirect()->route('siswa.pretest.done');
    }


    // halaman selesai (tanpa nilai)
    public function done()
    {
        return view('siswa.pretest.done');
    }
}