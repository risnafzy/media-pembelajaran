@extends('layouts.app')

@section('title', 'Tambah Pertanyaan Refleksi')

@section('head')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="py-8 min-h-screen bg-slate-50">
        <div class="max-w-4xl mx-auto px-4">

            {{-- BACK --}}
            <a href="{{ url()->previous() }}" class="text-sm text-slate-500 mb-4 inline-block">
                ← Kembali
            </a>

            <div class="bg-white p-8 rounded-2xl shadow">

                <h1 class="text-xl font-bold mb-6">
                    Tambah Pertanyaan Refleksi
                </h1>

                <form id="form-refleksi" method="POST" action="{{ route('guru.reflection.store', $course_id) }}">
                    @csrf

                    {{-- QUILL --}}
                    <div class="mb-6">

                            <label class="font-semibold block mb-2">Kategori</label>
                            <select name="kategori" class="border rounded px-3 py-2 w-full">
                                <option value="evaluasi">Evaluasi</option>
                                <option value="refleksi">Refleksi</option>
                            </select>

                        <label class="font-semibold block mb-2">
                            Pertanyaan Refleksi
                        </label>

                        <div id="editor-pertanyaan" class="bg-white border rounded" style="height:150px"></div>

                        <input type="hidden" name="pertanyaan" id="input-pertanyaan">
                    </div>

                    <button class="bg-blue-600 text-white px-6 py-2 rounded">
                        Simpan
                    </button>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        let quill = new Quill('#editor-pertanyaan', {
            theme: 'snow',
            placeholder: 'Tulis pertanyaan...'
        });

        // 🔥 FIX SUBMIT
        document.getElementById('form-refleksi')
            .addEventListener('submit', function(e) {

                let isi = quill.root.innerHTML;
                let text = quill.getText().trim();

                if (text.length === 0) {
                    alert('Pertanyaan tidak boleh kosong!');
                    e.preventDefault();
                    return;
                }

                document.getElementById('input-pertanyaan').value = isi;
            });
    </script>

@endsection
