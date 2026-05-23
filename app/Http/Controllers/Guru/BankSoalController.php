<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller
{

public function index()
{

        $pretest = BankSoal::where('guru_id',Auth::id())
        ->where('jenis','pretest')
        ->get();

        $posttest = BankSoal::where('guru_id',Auth::id())
        ->where('jenis','posttest')
        ->get();

        return view('guru.bank_soal.index',
        compact('pretest','posttest'));

        }



        public function create($jenis)
        {
        return view('guru.bank_soal.create',
        compact('jenis'));
}



public function store(Request $request)
{

BankSoal::create([

'guru_id'=>Auth::id(),
'jenis'=>$request->jenis,
'pertanyaan'=>$request->pertanyaan,

'opsi_a'=>$request->opsi_a,
'opsi_b'=>$request->opsi_b,
'opsi_c'=>$request->opsi_c,
'opsi_d'=>$request->opsi_d,
'opsi_e'=>$request->opsi_e,

'jawaban_benar'=>$request->jawaban_benar

]);

return redirect()
->route('guru.bank_soal.index');

}



public function edit($id)
{

$soal = BankSoal::findOrFail($id);

return view('guru.bank_soal.edit',
compact('soal'));

}



public function update(Request $request,$id)
{

$soal = BankSoal::findOrFail($id);

$soal->update($request->all());

return redirect()
->route('guru.bank_soal.index');

}



public function destroy($id)
{

BankSoal::destroy($id);

return back();

}

}