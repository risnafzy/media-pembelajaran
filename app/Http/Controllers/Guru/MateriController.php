<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{

    
    public function create($course_id)
    {

        $course = Course::where('guru_id',Auth::id())
            ->findOrFail($course_id);

        return view('guru.materi.create', compact('course'));

    }


    public function store(Request $request, $course_id)
    {

        $request->validate([
            'judul'=>'required',
            'konten'=>'required'
        ]);

        Materi::create([
            'course_id'=>$course_id,
            'judul'=>$request->judul,
            'konten'=>$request->konten
        ]);

        return redirect()
            ->route('guru.course.show',$course_id)
            ->with('success','Materi berhasil dibuat');

    }


    public function edit($id)
    {

        $materi = Materi::findOrFail($id);

        return view('guru.materi.edit', compact('materi'));

    }


public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required',
        'konten' => 'required'
    ]);

    $materi = Materi::findOrFail($id);

    $materi->update([
        'judul' => $request->judul,
        'konten' => $request->konten
    ]);

 return redirect()->route('guru.course.show', $materi->course_id);
}



    public function destroy($id)
    {

        $materi = Materi::findOrFail($id);

        $course_id = $materi->course_id;

        $materi->delete();

        return redirect()
            ->route('guru.course.show',$course_id)
            ->with('success','Materi berhasil dihapus');

    }

}