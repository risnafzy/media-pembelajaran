@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="py-10 min-h-screen bg-slate-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Edit Materi
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Perbarui informasi nama atau deskripsi course Anda di bawah ini.
                    </p>
                </div>

                <a href="{{ route('guru.course.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Batal
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <form method="POST" action="{{ route('guru.course.update', $course->id) }}" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="nama" class="block text-sm font-bold text-slate-700 mb-2">
                            Nama Course <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ $course->nama }}" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder:text-slate-400"
                            placeholder="Contoh: Pengantar Algoritma dan Struktur Data">
                    </div>

                    <div class="mb-8">
                        <label for="deskripsi" class="block text-sm font-bold text-slate-700 mb-2">
                            Deskripsi Materi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none resize-y placeholder:text-slate-400"
                            placeholder="Jelaskan secara singkat apa yang akan dipelajari siswa dalam materi ini...">{{ $course->deskripsi }}</textarea>
                    </div>

                    <div class="flex justify-end pt-5 border-t border-slate-100">
                        <button type="submit"
                            class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5 transition-transform group-hover:rotate-180 duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
