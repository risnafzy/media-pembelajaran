@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')

    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">
            Edit Materi
        </h1>

        {{-- 1. Tambahkan ID pada form agar spesifik --}}
        <form id="editForm" method="POST" action="{{ route('guru.materi.update', $materi->id) }}">
            @csrf
            @method('PUT')

            <label class="block font-medium text-gray-700 mb-1">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}"
                class="w-full border rounded p-2 mb-4">

            <label class="block font-medium text-gray-700 mb-1">Konten</label>

            {{-- Container Quill --}}
            <div id="editor" class="bg-white" style="height:300px">
                {!! old('konten', $materi->konten) !!}
            </div>

            {{-- Input Hidden untuk menampung data Quill --}}
            <input type="hidden" name="konten" id="konten">

            <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Update
            </button>
        </form>
    </div>

    {{-- Load Library Quill (Pastikan ini sudah ada di layout atau disini) --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
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

        // 2. Gunakan getElementById agar menargetkan form yang BENAR
        var form = document.getElementById('editForm');

        form.onsubmit = function() {
            // Ambil HTML dari Quill editor
            var kontenHTML = quill.root.innerHTML;

            // Masukkan ke dalam input hidden
            var kontenInput = document.querySelector('#konten');
            kontenInput.value = kontenHTML;

            // Debugging (Opsional: Cek di console browser jika masih gagal)
            // console.log("Form submitting...", kontenInput.value);
        };
    </script>

@endsection
