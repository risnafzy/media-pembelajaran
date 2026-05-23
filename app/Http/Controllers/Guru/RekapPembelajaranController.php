<?php

namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\InvestigationLog;
use App\Models\LkpdAnswer;
use App\Models\CodeRunnerResult;
use App\Models\Reflection;

class RekapPembelajaranController extends Controller
{
public function index()
{

$courses = Course::where('guru_id', auth()->id())->get();

$rekap = [];

foreach($courses as $course){

$students = Enrollment::where('course_id',$course->id)
->with('student')
->get();

foreach($students as $enroll){

$student = $enroll->student;

$investigation = InvestigationLog::where([
'student_id'=>$student->id,
'course_id'=>$course->id
])->exists();

$lkpd = LkpdAnswer::where([
'student_id'=>$student->id,
'course_id'=>$course->id
])->exists();

$coderunner = CodeRunnerResult::where([
'student_id'=>$student->id,
'course_id'=>$course->id
])->exists();

$refleksi = Reflection::where([
'student_id'=>$student->id,
'course_id'=>$course->id
])->exists();

$rekap[] = [

'course_id'=>$course->id,
'student_id'=>$student->id,
'student'=>$student->name,

'investigation'=>$investigation,
'lkpd'=>$lkpd,
'coderunner'=>$coderunner,
'refleksi'=>$refleksi

];

}
}

return view('guru.nilai.index',compact('rekap'));

}
}