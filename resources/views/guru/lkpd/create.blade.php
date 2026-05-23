@extends('layouts.app')

@section('title', 'Kelola LKPD')

@section('head')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="py-8 min-h-screen bg-slate-50">
    <div class="max-w-4xl mx-auto px-4">

        <a href="{{ route('guru.course.show', $course->id) }}"
            class="text-sm text-slate-500 mb-4 inline-block">
            ← Kembali
        </a>

        <form id="form-lkpd" method="POST" action="{{ route('guru.lkpd.store', $course->id) }}">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-4">
                <input type="text" name="judul" placeholder="Judul LKPD"
                    required class="w-full border p-3 rounded-lg">
            </div>

            {{-- STUDI KASUS --}}
            <div class="mb-6">
                <label class="font-semibold mb-2 block">Studi Kasus</label>
                <div id="editor-studi" class="bg-white border rounded" style="height:200px"></div>
                <input type="hidden" name="studi_kasus" id="studi_kasus">
            </div>

            {{-- QUESTIONS --}}
            <div id="questions-container"></div>

            <button type="button" onclick="addQuestion()"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                + Tambah Soal
            </button>

            <button class="bg-indigo-600 text-white px-6 py-2 rounded">
                Simpan LKPD
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
let questionIndex = 0;

// =====================
// QUILL STUDI KASUS
// =====================
var quillStudi = new Quill('#editor-studi', {
    theme: 'snow',
    placeholder: 'Tulis studi kasus...'
});

// =====================
// TAMBAH SOAL
// =====================
function addQuestion() {

    let qIndex = questionIndex;

    let html = `
    <div class="border p-6 rounded-xl mb-6 bg-white">

        <div class="font-bold mb-3 text-blue-600">
            Soal ${qIndex + 1}
        </div>

        <input type="hidden" name="questions[${qIndex}][no_soal]" value="${qIndex + 1}">

        <!-- MODE -->
        <div class="mb-3">
            <label class="text-xs font-semibold text-gray-500">Mode Soal</label>
            <select onchange="toggleSub(${qIndex}, this.value)"
                class="border p-2 rounded w-full text-sm">
                <option value="direct">Soal Langsung</option>
                <option value="sub">Dengan Sub Soal</option>
            </select>
        </div>

        <!-- DESKRIPSI / SOAL -->
        <div class="mb-4">
            <label class="text-sm font-semibold">Isi Soal</label>

            <div id="editor-q-${qIndex}" class="bg-white border rounded" style="height:120px"></div>
            <input type="hidden" name="questions[${qIndex}][deskripsi]" id="input-q-${qIndex}">
        </div>

        <!-- SUB WRAPPER -->
        <div id="sub-wrapper-${qIndex}" style="display:none;">
            <div id="subs-${qIndex}" class="ml-4 border-l pl-4 space-y-3"></div>

            <button type="button" onclick="addSub(${qIndex})"
                class="text-sm bg-green-500 text-white px-3 py-1 rounded mt-2">
                + Sub Soal
            </button>
        </div>

    </div>
    `;

    document.getElementById('questions-container').insertAdjacentHTML('beforeend', html);

    // INIT QUILL
    let quill = new Quill(`#editor-q-${qIndex}`, { theme: 'snow' });
    window['quill_q_' + qIndex] = quill;

    questionIndex++;
}

// =====================
// TOGGLE MODE
// =====================
function toggleSub(qIndex, value) {

    let wrapper = document.getElementById(`sub-wrapper-${qIndex}`);

    if (value === 'sub') {
        wrapper.style.display = 'block';

        let subs = document.querySelectorAll(`#subs-${qIndex} .sub`);
        if (subs.length === 0) {
            addSub(qIndex);
        }

    } else {
        wrapper.style.display = 'none';
    }
}

// =====================
// TAMBAH SUB
// =====================
function addSub(qIndex) {

    let container = document.getElementById(`subs-${qIndex}`);
    let subIndex = container.querySelectorAll('.sub').length;
    let label = String.fromCharCode(97 + subIndex);

    let html = `
    <div class="sub flex gap-2 items-start">

        <span class="mt-2 font-bold">${label}.</span>

        <input type="hidden"
            name="questions[${qIndex}][subs][${subIndex}][label]"
            value="${label}">

        <div class="w-full space-y-2">

            <div id="editor-sub-${qIndex}-${subIndex}"
                class="bg-white border rounded"
                style="height:100px"></div>

            <input type="hidden"
                name="questions[${qIndex}][subs][${subIndex}][pertanyaan]"
                id="input-sub-${qIndex}-${subIndex}">

            <select name="questions[${qIndex}][subs][${subIndex}][tipe_jawaban]"
                class="border p-2 rounded w-full text-sm">
                <option value="text">Teks</option>
                <option value="code">Code</option>
            </select>

        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);

    let quillSub = new Quill(`#editor-sub-${qIndex}-${subIndex}`, {
        theme: 'snow',
        placeholder: 'Tulis sub soal...'
    });

    window[`quill_sub_${qIndex}_${subIndex}`] = quillSub;
}

// =====================
// SUBMIT
// =====================
document.getElementById('form-lkpd').onsubmit = function() {

    // studi kasus
    document.getElementById('studi_kasus').value = quillStudi.root.innerHTML;

    for (let i = 0; i < questionIndex; i++) {

        let q = window['quill_q_' + i];

        if (q) {

            let value = q.root.innerHTML;

            if (value.trim() === '<p><br></p>') {
                alert('Soal tidak boleh kosong');
                return false;
            }

            document.getElementById(`input-q-${i}`).value = value;
        }

        let subs = document.querySelectorAll(`#subs-${i} .sub`);

        subs.forEach((el, sIndex) => {

            let sub = window[`quill_sub_${i}_${sIndex}`];

            if (sub) {
                document.getElementById(`input-sub-${i}-${sIndex}`).value =
                    sub.root.innerHTML;
            }
        });
    }
};

// INIT
document.addEventListener("DOMContentLoaded", function() {
    addQuestion();
});
</script>

@endsection
