@extends('layouts.app')

@section('title', 'Edit LKPD')

@section('head')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-8">

    <a href="{{ route('guru.course.show', $course->id) }}"
        class="text-sm text-slate-500 mb-4 inline-block">
        ← Kembali
    </a>

    <h2 class="text-xl font-semibold mb-6">
        Edit LKPD
    </h2>

    <form id="form-lkpd" method="POST" action="{{ route('guru.lkpd.update', $case->id) }}">
        @csrf
        @method('PUT')

        {{-- JUDUL --}}
        <input type="text" name="judul" value="{{ $case->judul }}"
            class="w-full border p-3 rounded-lg mb-4">

        {{-- STUDI KASUS --}}
        <div class="mb-6">
            <div id="editor-studi" style="height:200px" class="border rounded"></div>
            <input type="hidden" name="studi_kasus" id="studi_kasus">
        </div>

        {{-- SOAL --}}
        <div id="questions-container">

            @foreach ($case->questions as $qIndex => $q)
            <div class="border p-5 mb-5 rounded bg-slate-50 question-item">

                <b>Soal {{ $q->no_soal }}</b>

                <input type="hidden"
                    name="questions[{{ $qIndex }}][no_soal]"
                    value="{{ $q->no_soal }}">

                {{-- SOAL QUILL --}}
                <div id="editor-q-{{ $qIndex }}" style="height:120px" class="border rounded my-3"></div>
                <input type="hidden"
                    name="questions[{{ $qIndex }}][deskripsi]"
                    id="input-q-{{ $qIndex }}">

                {{-- SUB --}}
                <div id="subs-{{ $qIndex }}" class="space-y-3 ml-4">

                    @foreach ($q->subQuestions as $sIndex => $sub)
                    <div class="sub-item flex gap-2">

                        <span>{{ $sub->label }}.</span>

                        <input type="hidden"
                            name="questions[{{ $qIndex }}][subs][{{ $sIndex }}][label]"
                            value="{{ $sub->label }}">

                        <div class="w-full">
                            <div id="editor-sub-{{ $qIndex }}-{{ $sIndex }}"
                                style="height:100px"
                                class="border rounded"></div>

                            <input type="hidden"
                                name="questions[{{ $qIndex }}][subs][{{ $sIndex }}][pertanyaan]"
                                id="input-sub-{{ $qIndex }}-{{ $sIndex }}">
                        </div>

                        <button type="button" onclick="removeSub(this)">✕</button>
                    </div>
                    @endforeach

                </div>

                <button type="button" onclick="addSub({{ $qIndex }})"
                    class="bg-green-500 text-white px-3 py-1 mt-2 rounded">
                    + Sub
                </button>

            </div>
            @endforeach

        </div>

        <button type="button" onclick="addQuestion()"
            class="bg-blue-500 text-white px-4 py-2 mb-4 rounded">
            + Soal
        </button>

        <button class="bg-indigo-600 text-white px-6 py-2 rounded">
            Update
        </button>

    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
let questionIndex = {{ $case->questions->count() }};

// =================
// STUDI KASUS
// =================
let quillStudi = new Quill('#editor-studi',{theme:'snow'});
quillStudi.root.innerHTML = `{!! addslashes($case->studi_kasus) !!}`;


// =================
// INIT SOAL LAMA
// =================
@foreach ($case->questions as $qIndex => $q)
let q{{ $qIndex }} = new Quill('#editor-q-{{ $qIndex }}',{theme:'snow'});
q{{ $qIndex }}.root.innerHTML = `{!! addslashes($q->deskripsi) !!}`;
window['quill_q_{{ $qIndex }}'] = q{{ $qIndex }};
@endforeach


// =================
// INIT SUB LAMA
// =================
@foreach ($case->questions as $qIndex => $q)
@foreach ($q->subQuestions as $sIndex => $sub)

let sub_{{ $qIndex }}_{{ $sIndex }} =
    new Quill('#editor-sub-{{ $qIndex }}-{{ $sIndex }}',{theme:'snow'});

sub_{{ $qIndex }}_{{ $sIndex }}.root.innerHTML =
    `{!! addslashes($sub->pertanyaan) !!}`;

window['quill_sub_{{ $qIndex }}_{{ $sIndex }}'] =
    sub_{{ $qIndex }}_{{ $sIndex }};

@endforeach
@endforeach


// =================
// TAMBAH SOAL
// =================
function addQuestion(){

    let html = `
    <div class="border p-5 mb-5 rounded bg-slate-50 question-item">

        <b>Soal ${questionIndex+1}</b>

        <input type="hidden" name="questions[${questionIndex}][no_soal]" value="${questionIndex+1}">

        <div id="editor-q-${questionIndex}" style="height:120px" class="border rounded my-3"></div>
        <input type="hidden" name="questions[${questionIndex}][deskripsi]" id="input-q-${questionIndex}">

        <div id="subs-${questionIndex}" class="ml-4 space-y-3"></div>

        <button type="button" onclick="addSub(${questionIndex})"
            class="bg-green-500 text-white px-3 py-1 mt-2 rounded">
            + Sub
        </button>
    </div>
    `;

    document.getElementById('questions-container').insertAdjacentHTML('beforeend',html);

    let q = new Quill(`#editor-q-${questionIndex}`,{theme:'snow'});
    window['quill_q_'+questionIndex]=q;

    addSub(questionIndex);
    questionIndex++;
}


// =================
// TAMBAH SUB (QUILL)
// =================
function addSub(qIndex){

    let container = document.getElementById(`subs-${qIndex}`);
    let subIndex = container.querySelectorAll('.sub-item').length;
    let label = String.fromCharCode(97 + subIndex);

    let html = `
    <div class="sub-item flex gap-2">

        <span>${label}.</span>

        <input type="hidden"
            name="questions[${qIndex}][subs][${subIndex}][label]"
            value="${label}">

        <div class="w-full">
            <div id="editor-sub-${qIndex}-${subIndex}" class="border rounded" style="height:100px"></div>
            <input type="hidden"
                name="questions[${qIndex}][subs][${subIndex}][pertanyaan]"
                id="input-sub-${qIndex}-${subIndex}">
        </div>

        <button type="button" onclick="removeSub(this)">✕</button>
    </div>
    `;

    container.insertAdjacentHTML('beforeend',html);

    let sub = new Quill(`#editor-sub-${qIndex}-${subIndex}`,{theme:'snow'});
    window[`quill_sub_${qIndex}_${subIndex}`]=sub;
}


// =================
function removeSub(btn){
    btn.closest('.sub-item').remove();
}

function removeQuestion(btn){
    btn.closest('.question-item').remove();
}


// =================
// SUBMIT
// =================
document.getElementById('form-lkpd').onsubmit = function(){

    document.getElementById('studi_kasus').value =
        quillStudi.root.innerHTML;

    for(let i=0;i<questionIndex;i++){

        let q = window['quill_q_'+i];
        if(q){
            document.getElementById(`input-q-${i}`).value =
                q.root.innerHTML;
        }

        let subs = document.querySelectorAll(`#subs-${i} .sub-item`);

        subs.forEach((el,sIndex)=>{
            let sub = window[`quill_sub_${i}_${sIndex}`];
            if(sub){
                document.getElementById(`input-sub-${i}-${sIndex}`).value =
                    sub.root.innerHTML;
            }
        });
    }
};
</script>

@endsection
