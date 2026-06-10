@extends('layouts.learning')

@section('title', 'LKPD Awal')
@section('page-title', 'LKPD Awal')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">

            <div class="w-12 h-12 shrink-0 bg-[#EBF4F6] rounded-xl flex items-center justify-center text-[#088395]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            </div>

            <div class="text-center md:text-left">
                <h2 class="text-sm font-black text-[#071952] uppercase tracking-tight leading-none mb-1">
                    Bagian A: Analisis Masalah
                </h2>

                <p class="text-xs text-slate-500 font-medium">
                    Selesaikan analisis studi kasus modul
                    <span class="text-[#088395] font-bold">
                        {{ $course->nama ?? 'Ini' }}
                    </span>
                </p>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- PILIH STUDI KASUS --}}
        {{-- ========================================================= --}}
        @if (!$selectedCase)

            <div class="bg-slate-50/50 p-6 md:p-10 rounded-3xl border border-dashed border-slate-300">

                <div class="max-w-2xl mx-auto mb-12 text-center">

                    <h3 class="text-xl font-black text-[#071952] mb-3 tracking-tight">
                        Pilih Studi Kasus
                    </h3>

                    <p class="text-sm text-slate-500 font-medium">
                        Skenario mana yang ingin kamu pecahkan hari ini?
                    </p>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">

                    @foreach ($cases as $case)
                        <form method="POST" action="{{ route('siswa.course.lkpd.pilihKasus', $course->id) }}"
                            class="w-full">

                            @csrf

                            <input type="hidden" name="kasus" value="{{ $case->id }}">

                            <button type="submit"
                                class="w-full group relative flex flex-col items-center p-8 bg-white border-2 border-slate-200 rounded-4xl hover:border-[#37B7C3] hover:shadow-2xl hover:shadow-[#37B7C3]/15 transition-all duration-500 text-center">

                                {{-- ICON --}}
                                <div
                                    class="w-20 h-20 bg-[#EBF4F6] text-[#088395] rounded-2xl flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:bg-[#37B7C3] group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg">

                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>

                                {{-- TEXT --}}
                                <div class="flex-1 flex flex-col justify-center">

                                    <span
                                        class="text-[10px] font-bold text-[#37B7C3] uppercase tracking-[0.25em] mb-2 block">

                                        Skenario Masalah

                                    </span>

                                    <h4
                                        class="text-lg font-black text-[#071952] leading-tight group-hover:text-[#088395] transition-colors">

                                        {{ $case->judul }}

                                    </h4>
                                </div>

                                {{-- ACTION --}}
                                <div
                                    class="mt-6 pt-4 border-t border-slate-100 w-full flex items-center justify-center text-xs font-bold text-slate-400 group-hover:text-[#37B7C3] transition-all">

                                    Mulai Analisis

                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3">
                                        </path>

                                    </svg>
                                </div>

                            </button>

                        </form>
                    @endforeach

                </div>
            </div>
        @else
            @php

                $idsAwal = $selectedCase->questions->flatMap(
                    fn($q) => $q->subQuestions->count() > 0 ? $q->subQuestions->pluck('id') : collect([$q->id]),
                );

                $jawabanTerisi = collect($jawaban)->keys();

                $sudahIsi = $idsAwal->intersect($jawabanTerisi)->count() === $idsAwal->count();

            @endphp

            {{-- ========================================================= --}}
            {{-- DETAIL STUDI KASUS --}}
            {{-- ========================================================= --}}
            <div class="overflow-hidden bg-[#071952] rounded-2xl border border-blue-900 shadow-lg relative">

                <div class="px-5 py-2.5 bg-white/5 border-b border-white/5 flex items-center justify-between">

                    <span class="text-[9px] font-mono text-slate-400 uppercase tracking-widest">
                        Studi_Kasus.md
                    </span>

                </div>

                <div class="p-6 md:p-8">

                    <h3 class="text-lg font-bold text-white mb-4">

                        <span class="text-[#37B7C3]">#</span>

                        {{ $selectedCase->judul ?? '' }}

                    </h3>

                    <div class="prose prose-invert prose-sm text-slate-300 max-w-none">
                        {!! $selectedCase->studi_kasus ?? '' !!}
                    </div>

                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- PERTANYAAN --}}
            {{-- ========================================================= --}}
            <div class="space-y-4">

                <div class="flex items-center gap-4 py-2">

                    <h2 class="text-sm font-black text-[#071952] uppercase tracking-wider">
                        Analisis Pertanyaan
                    </h2>

                    <div class="h-px flex-1 bg-slate-200"></div>

                </div>

                <form method="POST" action="{{ route('siswa.course.lkpd.store', $course->id) }}">

                    @csrf

                    @foreach ($selectedCase->questions as $q)
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm mb-6">

                            <div class="grid grid-cols-[auto_1fr] gap-6">

                                {{-- NOMOR --}}
                                <div class="flex flex-col items-center">

                                    <div
                                        class="w-10 h-10 bg-[#071952] text-[#37B7C3] rounded-xl flex items-center justify-center text-lg font-black shadow-lg shadow-[#071952]/20">

                                        {{ $q->no_soal }}

                                    </div>

                                    <div class="w-0.5 h-full bg-slate-100 mt-2 rounded-full"></div>

                                </div>

                                {{-- KONTEN --}}
                                <div class="flex-1 pt-1">

                                    <div class="mb-6 text-base font-bold text-[#071952] leading-relaxed">
                                        {!! $q->deskripsi !!}
                                    </div>

                                    <div class="space-y-6">

                                        @if ($q->subQuestions->count() > 0)
                                            @foreach ($q->subQuestions as $sub)
                                                <div class="relative pl-6 border-l-2 border-[#37B7C3]/30">

                                                    <div class="flex gap-2 text-sm text-slate-800 mb-3">

                                                        <span
                                                            class="px-2 py-0.5 bg-[#EBF4F6] text-[#088395] text-xs font-black rounded">

                                                            {{ $sub->label }}

                                                        </span>

                                                        <div>
                                                            {!! $sub->pertanyaan !!}
                                                        </div>

                                                    </div>

                                                    <textarea name="jawaban_sub[{{ $sub->id }}]" rows="3" {{ $sudahIsi ? 'readonly' : 'required' }}
                                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700
                                                    focus:border-[#37B7C3] focus:bg-white focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-sm
                                                    {{ $sudahIsi ? 'bg-slate-100 text-slate-500 italic cursor-not-allowed' : '' }}"
                                                        placeholder="Ketik jawaban Anda di sini...">{{ $jawaban[$sub->id] ?? '' }}</textarea>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="space-y-2">

                                                <label class="text-xs font-black uppercase tracking-wider text-slate-400">

                                                    Jawaban Anda:

                                                </label>

                                                <textarea name="jawaban_q[{{ $q->id }}]" rows="4" {{ $sudahIsi ? 'readonly' : 'required' }}
                                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700
                                                focus:border-[#37B7C3] focus:bg-white focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-sm
                                                {{ $sudahIsi ? 'bg-slate-100 text-slate-500 italic cursor-not-allowed' : '' }}"
                                                    placeholder="Ketik jawaban Anda di sini...">{{ $jawaban[$q->id] ?? '' }}</textarea>

                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    {{-- NAVIGASI --}}
                    <div class="flex justify-between items-center pt-8 mt-6 border-t border-slate-200">

                        <a href="{{ route('siswa.course.orientasi.show', $course->id) }}"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-xs bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-xl shadow transition-all">

                            ← Kembali

                        </a>

                        @if (!$sudahIsi)
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 text-xs bg-green-600 hover:bg-green-800 text-white font-bold rounded-xl shadow transition-all">

                                Simpan Jawaban

                            </button>
                        @else
                            <a href="{{ route('siswa.course.materi', $course->id) }}"
                                class="inline-flex items-center gap-2 px-6 py-2.5 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-xl shadow transition-all">

                                Lanjut ke Materi

                            </a>
                        @endif

                    </div>

                </form>

            </div>

        @endif

    </div>
@endsection
