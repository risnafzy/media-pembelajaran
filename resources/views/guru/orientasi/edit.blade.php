@extends('layouts.app')

@section('title', 'Edit Orientasi')

@section('head')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="p-6">

        <h1 class="text-xl font-bold mb-6">
            Edit Orientasi
        </h1>

        <form id="form-edit-orientasi" method="POST" action="{{ route('guru.orientasi.update', $orientasi->id) }}">
            @csrf
            @method('PUT')

            {{-- TUJUAN --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">
                    Tujuan Pembelajaran
                </label>
                <textarea name="tujuan" rows="3" required class="w-full border rounded-lg p-3 focus:ring focus:ring-indigo-200">{{ $orientasi->tujuan }}</textarea>
            </div>

            {{-- ISI ORIENTASI --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">
                    Isi Orientasi
                </label>

                <div id="editor" style="height: 300px;" class="bg-white rounded-t-lg border">
                    {!! $orientasi->isi !!}
                </div>

                <input type="hidden" name="isi" id="isi">
            </div>

            {{-- pemahaman awal as PERTANYAAN PEMANTIK --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <label class="block font-semibold">
                        Pemahaman awal
                    </label>
                    <button type="button" onclick="tambahPertanyaan()" class="bg-green-500 text-white px-3 py-1 rounded">
                        + Tambah
                    </button>
                </div>

                <div id="pertanyaan-container">

                    @foreach ($orientasi->pertanyaan->sortBy('urutan') as $p)
                        <div class="border p-4 rounded mb-3 bg-gray-50">

                            <textarea name="pertanyaan[]" class="w-full border p-2 rounded mb-2" placeholder="Tulis pertanyaan...">{{ $p->pertanyaan }}</textarea>

                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <select name="tipe[]" class="border p-2 rounded">
                                    <option value="">Tipe Pertanyaan</option>
                                    <option value="analisis" {{ $p->tipe == 'analisis' ? 'selected' : '' }}>Analisis
                                    </option>
                                    <option value="prediksi" {{ $p->tipe == 'prediksi' ? 'selected' : '' }}>Prediksi
                                    </option>
                                    <option value="debugging" {{ $p->tipe == 'debugging' ? 'selected' : '' }}>Debugging
                                    </option>
                                    <option value="refleksi" {{ $p->tipe == 'refleksi' ? 'selected' : '' }}>Refleksi
                                    </option>
                                </select>

                                <select name="level_kognitif[]" class="border p-2 rounded">
                                    <option value="">Level Kognitif</option>
                                    <option value="C3" {{ $p->level_kognitif == 'C3' ? 'selected' : '' }}>C3</option>
                                    <option value="C4" {{ $p->level_kognitif == 'C4' ? 'selected' : '' }}>C4</option>
                                    <option value="C5" {{ $p->level_kognitif == 'C5' ? 'selected' : '' }}>C5</option>
                                </select>
                            </div>

                            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 text-sm">
                                Hapus
                            </button>
                        </div>
                    @endforeach

                </div>
            </div>

            <button type="submit" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                Update Orientasi
            </button>

        </form>

    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tulis orientasi berbasis masalah...',
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
                    ['link', 'image']
                ]
            }
        });

        var form = document.getElementById('form-edit-orientasi');

        form.onsubmit = function(e) {
            document.querySelector('#isi').value = quill.root.innerHTML;

            if (quill.getText().trim().length === 0) {
                alert('Isi orientasi tidak boleh kosong!');
                e.preventDefault();
            }
        };

        function tambahPertanyaan() {
            let container = document.getElementById('pertanyaan-container');

            let div = document.createElement('div');
            div.classList.add('border', 'p-4', 'rounded', 'mb-3', 'bg-gray-50');

            div.innerHTML = `
        <textarea name="pertanyaan[]"
                  class="w-full border p-2 rounded mb-2"
                  placeholder="Tulis pertanyaan..."></textarea>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <select name="tipe[]" class="border p-2 rounded">
                <option value="">Tipe Pertanyaan</option>
                <option value="analisis">Analisis</option>
                <option value="prediksi">Prediksi</option>
                <option value="debugging">Debugging</option>
                <option value="refleksi">Refleksi</option>
            </select>

            <select name="level_kognitif[]" class="border p-2 rounded">
                <option value="">Level Kognitif</option>
                <option value="C3">C3</option>
                <option value="C4">C4</option>
                <option value="C5">C5</option>
            </select>
        </div>

        <button type="button"
                onclick="this.parentElement.remove()"
                class="text-red-600 text-sm">
            Hapus
        </button>
    `;

            container.appendChild(div);
        }
    </script>

@endsection
