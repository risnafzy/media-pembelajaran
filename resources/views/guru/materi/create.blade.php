@extends('layouts.app')

@section('title', 'Tambah Materi')

@section('content')
    {{-- 1. PENTING: Link CSS Quill harus ada di sini --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">
            Tambah Materi - {{ $course->nama }}
        </h1>

        <form method="POST" action="{{ route('guru.materi.store', $course->id) }}" id="form-materi">
            @csrf

            {{-- Input Judul --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul</label>
                <input type="text" name="judul" class="w-full border rounded p-2" required>
            </div>

            {{-- Input Konten --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Konten</label>
                {{-- Container Editor dengan styling border agar terlihat jelas --}}
                <div class="bg-white">
                    <div id="editor" style="height: 300px;"></div>
                </div>
            </div>

            {{-- Input Hidden untuk menyimpan isi editor --}}
            <input type="hidden" name="konten" id="konten">

            <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Simpan
            </button>
        </form>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tulis materi disini...',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image'] // 🔥 ini yang bikin bisa upload gambar
                    ]
                }
            });

            var form = document.getElementById('form-materi');

            form.addEventListener('submit', function() {

                var html = quill.root.innerHTML;

                document.getElementById('konten').value = html;

            });

        });
    </script>


@endsection
