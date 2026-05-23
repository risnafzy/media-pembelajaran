@extends('layouts.app')

@section('title', 'Detail Jawaban LKPD')

@section('head')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="py-8 min-h-screen bg-slate-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="bg-[#071952] rounded-3xl shadow-xl shadow-blue-900/10 mb-8 overflow-hidden relative">

                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-2xl">
                </div>

                <div class="px-8 py-8 flex items-center gap-6 relative z-10">
                    <div
                        class="w-16 h-16 rounded-2xl bg-[#37B7C3] text-white flex items-center justify-center font-black text-3xl shadow-lg border border-white/10">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <span
                            class="inline-block px-3 py-1 bg-white/10 text-blue-100 text-xs font-semibold rounded-full tracking-wide mb-2 backdrop-blur-sm">
                            LEMBAR JAWABAN SISWA
                        </span>

                        <h1 class="text-3xl font-bold text-white tracking-tight">
                            {{ $user->name }}
                        </h1>
                    </div>
                </div>
            </div>

            {{-- FORM NILAI --}}
            <form action="{{ route('guru.nilai.save') }}" method="POST">
                @csrf

                <input type="hidden" name="answer_id" value="{{ $answers->first()->id ?? '' }}">

                <div class="space-y-8">

                    @php
                        $selectedCase = $cases->first(function ($case) use ($answers) {
                            return $case->questions->contains(function ($q) use ($answers) {
                                if ($answers->where('question_id', $q->id)->count()) {
                                    return true;
                                }

                                return $q->subQuestions->contains(function ($sub) use ($answers) {
                                    return $answers->where('sub_question_id', $sub->id)->count();
                                });
                            });
                        });
                    @endphp

                    @if ($selectedCase)

                        {{-- STUDI KASUS --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 border-b border-slate-200 px-6 py-5">

                                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500"
                                        viewBox="0 0 20 20" fill="currentColor">

                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>

                                    Studi Kasus: {{ $selectedCase->judul }}
                                </h3>
                            </div>
                        </div>

                        {{-- JAWABAN --}}
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

                            <h4 class="text-base font-bold text-slate-800 mb-6 pb-2 border-b border-slate-100">
                                Evaluasi Jawaban
                            </h4>

                            @foreach ($selectedCase->questions as $q)
                                <div class="mb-10 last:mb-0">

                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-lg">
                                            Soal {{ $q->no_soal }}
                                        </span>
                                    </div>

                                    {{-- DESKRIPSI --}}
                                    @if ($q->deskripsi)
                                        <p
                                            class="text-sm text-slate-600 mb-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                            {!! $q->deskripsi !!}
                                        </p>
                                    @endif

                                    <div class="space-y-5 mt-4">

                                        @if ($q->subQuestions->count() > 0)
                                            {{-- SUB SOAL --}}
                                            @foreach ($q->subQuestions as $sub)
                                                @php
                                                    $jawaban = $answers->firstWhere('sub_question_id', $sub->id);
                                                @endphp

                                                <div
                                                    class="ml-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 transition-colors shadow-sm">

                                                    <div class="text-sm font-semibold text-slate-800 mb-3 flex gap-2">
                                                        <span class="text-indigo-500">
                                                            {{ $sub->label }}.
                                                        </span>

                                                        <div>
                                                            {!! $sub->pertanyaan !!}
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">

                                                        <p
                                                            class="text-xs text-slate-500 font-medium mb-1 uppercase tracking-wide">
                                                            Jawaban Siswa:
                                                        </p>

                                                        <div
                                                            class="text-sm text-slate-700 bg-slate-50 border-l-4 border-indigo-400 p-3 rounded-r-lg">

                                                            {{ $jawaban->jawaban ?? 'Belum menjawab' }}

                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        @else
                                            {{-- SOAL LANGSUNG --}}
                                            @php
                                                $jawaban = $answers->firstWhere('question_id', $q->id);
                                            @endphp

                                            <div
                                                class="ml-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 transition-colors shadow-sm">

                                                <div class="mb-4">

                                                    <p
                                                        class="text-xs text-slate-500 font-medium mb-1 uppercase tracking-wide">
                                                        Jawaban Siswa:
                                                    </p>

                                                    <div
                                                        class="text-sm text-slate-700 bg-slate-50 border-l-4 border-indigo-400 p-3 rounded-r-lg">

                                                        {{ $jawaban->jawaban ?? 'Belum menjawab' }}

                                                    </div>
                                                </div>

                                            </div>
                                        @endif

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        {{-- PENILAIAN GURU --}}
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 mt-8">

                            <h3 class="text-lg font-bold text-slate-800 mb-6">
                                Penilaian Guru
                            </h3>

                            {{-- NILAI --}}
                            <div class="mb-5">

                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nilai Akhir
                                </label>

                                <input type="number" name="score" min="0" max="100"
                                    value="{{ $existingScore->score ?? '' }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan nilai akhir">

                            </div>

                            {{-- KOMENTAR --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Komentar Guru
                                </label>

                                <textarea name="feedback" rows="5"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tulis komentar untuk siswa...">{{ $existingScore->feedback ?? '' }}</textarea>

                            </div>

                        </div>
                    @else
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 flex flex-col items-center justify-center text-center">

                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>

                            </div>

                            <h3 class="text-lg font-bold text-slate-700">
                                Tidak Ada Data
                            </h3>

                            <p class="text-slate-500 text-sm mt-1">
                                Belum ada jawaban yang direkam untuk siswa ini.
                            </p>

                        </div>

                    @endif

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-slate-200">

                    <a href="{{ route('guru.nilai.rekap.lkpd') }}"
                        class="px-6 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold transition-colors flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>

                        Kembali
                    </a>

                    <button type="submit"
                        class="px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>

                        Simpan Nilai
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection
