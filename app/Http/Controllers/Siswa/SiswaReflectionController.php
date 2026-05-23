<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReflectionQuestion;
use App\Models\ReflectionAnswer;
use App\Models\Course;
use App\Models\CourseProgress;
use Illuminate\Support\Facades\Auth;

class SiswaReflectionController extends Controller
{

public function index(Course $course)
{
    $evaluasiQuestions = ReflectionQuestion::where('course_id',$course->id)
    ->where('kategori','evaluasi')
    ->get();

    $refleksiQuestions = ReflectionQuestion::where('course_id',$course->id)
        ->where('kategori','refleksi')
        ->get();

    $allQuestionIds = $evaluasiQuestions->pluck('id')
        ->merge($refleksiQuestions->pluck('id'));

    $answers = ReflectionAnswer::where('student_id',Auth::id())
    ->whereIn('question_id',$allQuestionIds)
    ->get()
    ->keyBy('question_id');

    $alreadyFilled = ReflectionAnswer::where('student_id',Auth::id())
        ->whereIn('question_id',$allQuestionIds)
        ->exists();

    /*
    ======================
    PROGRESS LMS (FIX)
    ======================
    */

    $progress = CourseProgress::firstOrCreate([
        'user_id' => Auth::id(),
        'course_id' => $course->id
    ]);

    $done = collect([
        $progress->orientasi ,
        $progress->lkpd1 ,
        $progress->materi ,
        $progress->lkpd2 ,
        $progress->presentasi_done ,
        $progress->refleksi
    ])->filter()->count();

    $percent = ($done / 6) * 100;

    $unlock = [
        'orientasi' => true,
        'lkpd' => $progress->orientasi ,
        'materi' => $progress->lkpd1 ,
        'lkpd_lanjutan' => $progress->materi ,
        'presentasi' => $progress->lkpd2 ,
        'refleksi' => $progress->presentasi_done
    ];

    return view('siswa.reflection.index',[
        'evaluasiQuestions'=>$evaluasiQuestions,
        'refleksiQuestions'=>$refleksiQuestions,
        'answers'=>$answers,
        'course'=>$course,
        'alreadyFilled'=>$alreadyFilled,

        'progress'=>$progress,
        'progressPercent'=>$percent,
        'unlock'=>$unlock,
        'active'=>'refleksi',
        'step'=>6
    ]);
}


    public function store(Request $request, $course)
    {
        $request->validate([
        'jawaban.*' => 'required'
        ]);

        $exists = ReflectionAnswer::where('student_id',Auth::id())
            ->whereHas('question', function($q) use ($course){
                $q->where('course_id',$course);
            })
            ->exists();

        if($exists){
            return redirect()
                ->route('siswa.course.show', $course)
                ->with('error','Refleksi hanya dapat diisi satu kali.');
        }

        foreach ($request->jawaban as $question_id => $jawaban) {

            ReflectionAnswer::create([
                'question_id' => $question_id,
                'student_id' => Auth::id(),
                'jawaban' => $jawaban
            ]);

        }

        /*
        ======================
        UPDATE PROGRESS
        ======================
        */

        $progress = CourseProgress::where('user_id',Auth::id())
            ->where('course_id',$course)
            ->first();

        if($progress){
            $progress->refleksi  = true;
            $progress->save();
        }

        return redirect()
            ->route('siswa.course.reflection.index', $course)
            ->with('success','Jawaban refleksi berhasil disimpan');
    }

}
