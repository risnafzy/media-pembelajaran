<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Orientasi;
use App\Models\Course;
use App\Models\PertanyaanOrientasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JawabanPertanyaanOrientasi;
use App\Models\OrientasiFeedback;


class OrientasiController extends Controller
{
    public function create($course_id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($course_id);

        return view('guru.orientasi.create', compact('course'));
    }

    public function rekapOrientasi()
    {
        $courses = Course::with([
            'orientasi.pertanyaan.jawaban.user'
        ])->get();

        return view('guru.orientasi.rekap', compact('courses'));
    }

    public function showRekapOrientasi($courseId, $userId)
    {
        $orientasi = Orientasi::where('course_id', $courseId)
            ->with([
                'pertanyaan.jawaban' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ])
            ->firstOrFail();

        $user = \App\Models\User::findOrFail($userId);

        $feedback = OrientasiFeedback::where(
            'user_id',
            $userId
        )->where(
            'course_id',
            $courseId
        )->first();

        return view(
            'guru.orientasi.show',
            compact(
                'orientasi',
                'user',
                'feedback'
            )
        );
    }

    public function store(Request $request, $course_id)
    {
        $course = Course::where('guru_id', Auth::id())
            ->findOrFail($course_id);

        $request->validate([
            'tujuan' => 'required',
            'isi' => 'required',
            'pertanyaan.*' => 'nullable|string'
        ]);

        // Simpan orientasi
        $orientasi = Orientasi::create([
            'course_id' => $course->id,
            'tujuan' => $request->tujuan,
            'isi' => $request->isi,
        ]);

        // Simpan banyak pertanyaan
        if ($request->has('pertanyaan')) {
            foreach ($request->pertanyaan as $index => $p) {
                if ($p != null) {
                    PertanyaanOrientasi::create([
                        'orientasi_id' => $orientasi->id,
                        'pertanyaan' => $p,
                        'tipe' => $request->tipe[$index] ?? null,
                        'level_kognitif' => $request->level_kognitif[$index] ?? null,
                        'urutan' => $index + 1
                    ]);
                }
            }
        }

        return redirect()
            ->route('guru.course.show', $course->id)
            ->with('success', 'Orientasi berhasil ditambahkan');
    }

    public function orientasiJawaban($course)
    {
        $jawaban = JawabanPertanyaanOrientasi::with(['user','pertanyaan'])
            ->whereHas('pertanyaan', function ($q) use ($course) {
                $q->where('course_id', $course);
            })
            ->get()
            ->groupBy('user_id');

        return view('guru.orientasi.jawaban', compact('jawaban'));
    }
    public function edit($id)
    {
        $orientasi = Orientasi::with('pertanyaan')
            ->findOrFail($id);

        return view('guru.orientasi.edit', compact('orientasi'));
    }

    public function update(Request $request, $id)
    {
        $orientasi = Orientasi::with('pertanyaan')
            ->findOrFail($id);

        $request->validate([
            'tujuan' => 'required',
            'isi' => 'required'
        ]);

        $orientasi->update([
            'tujuan' => $request->tujuan,
            'isi' => $request->isi
        ]);

        // Hapus pertanyaan lama (biar bersih)
        $orientasi->pertanyaan()->delete();

        // Simpan ulang pertanyaan baru
        if ($request->has('pertanyaan')) {
            foreach ($request->pertanyaan as $index => $p) {
                if ($p != null) {
                    PertanyaanOrientasi::create([
                        'orientasi_id' => $orientasi->id,
                        'pertanyaan' => $p,
                        'tipe' => $request->tipe[$index] ?? null,
                        'level_kognitif' => $request->level_kognitif[$index] ?? null,
                        'urutan' => $index + 1
                    ]);
                }
            }
        }

        return redirect()
            ->route('guru.course.show', $orientasi->course_id)
            ->with('success', 'Orientasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $orientasi = Orientasi::findOrFail($id);

        $course_id = $orientasi->course_id;

        $orientasi->delete(); // otomatis hapus pertanyaan karena cascade

        return redirect()
            ->route('guru.course.show', $course_id)
            ->with('success', 'Orientasi berhasil dihapus');
    }

    public function saveFeedbackOrientasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'komentar' => 'required|string'
        ]);

        OrientasiFeedback::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'course_id' => $request->course_id
            ],
            [
                'komentar' => $request->komentar
            ]
        );

        return back()->with(
            'success',
            'Feedback berhasil disimpan'
        );
    }


}
