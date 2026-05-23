@extends('layouts.learning')

@section('title', 'Presentasi')
@section('page-title', 'Presentasi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pb-10 font-poppins">

        @php
            $finalScore = $score->score ?? null;
            $feedback = $score->feedback ?? null;
        @endphp

        {{-- HEADER --}}
        <div
            class="flex flex-col md:flex-row gap-4 items-center bg-white p-6 rounded-2xl border-l-4 border-l-[#088395] border-y border-r border-slate-200 shadow-sm mt-4">
            <div
                class="w-14 h-14 shrink-0 bg-[#EBF4F6] rounded-2xl flex items-center justify-center text-[#088395] shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>

            <div class="text-center md:text-left flex-1">
                <h1 class="text-xl font-black text-[#071952] uppercase tracking-tight leading-none mb-1">
                    Hasil LKPD Siswa
                </h1>

                <p class="text-xs text-slate-500 font-medium italic">
                    Review jawaban dan hasil evaluasi pembelajaran Anda.
                </p>
            </div>
        </div>

        {{-- HASIL EVALUASI & KOMENTAR --}}
        <div
            class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col md:flex-row gap-5 items-stretch">

            {{-- Kotak Nilai Akhir --}}
            <div
                class="w-full md:w-48 shrink-0 bg-[#071952] rounded-xl p-5 flex flex-col items-center justify-center text-white relative overflow-hidden border border-blue-800 shadow-md">

                <div class="relative z-10 text-center flex flex-col items-center justify-center">

                    <div class="text-xs uppercase font-bold text-white/70 mb-1.5 tracking-wider">
                        Nilai Akhir
                    </div>

                    @if ($finalScore !== null)
                        {{-- Tampilan jika sudah dinilai --}}
                        <div class="text-4xl font-black text-[#37B7C3]">
                            {{ $finalScore }}
                        </div>
                    @else
                        {{-- Tampilan jika belum dinilai (Bentuk Badge/Label) --}}
                        <div
                            class="inline-flex items-center gap-1.5 mt-1 px-3 py-1.5 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-semibold rounded-lg shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Belum Dinilai
                        </div>
                    @endif

                </div>

            </div>

            {{-- Kotak Komentar Guru --}}
            <div class="flex-1 w-full flex flex-col justify-center">
                <h3 class="text-sm font-black text-[#071952] mb-2 uppercase tracking-wide flex items-center gap-2">
                    Komentar Guru
                </h3>

                @if ($feedback)
                    <div
                        class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs text-slate-700 leading-relaxed">
                        {{ $feedback }}
                    </div>
                @else
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs text-slate-400 italic">
                        Belum ada komentar atau evaluasi dari guru.
                    </div>
                @endif
            </div>

        </div>

        {{-- STUDI KASUS --}}
        <div class="bg-[#071952] rounded-4xl overflow-hidden shadow-xl relative border border-blue-900">

            <div class="px-5 py-3 bg-white/5 border-b border-white/5 flex items-center gap-2">

                <div class="flex gap-1.5 mr-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500/80"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500/80"></div>
                </div>

                <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest">
                    kasus_pembelajaran.sh
                </span>

            </div>

            <div class="p-8 relative z-10">

                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-[#37B7C3] font-mono">➜</span>
                    {{ $case->judul }}
                </h2>

                <div class="prose prose-invert prose-sm max-w-none text-slate-300 leading-relaxed font-light">
                    {!! $case->studi_kasus !!}
                </div>

            </div>
        </div>

        {{-- LIST SOAL --}}
        <div class="space-y-8">

            @foreach ($case->questions as $question)
                <div
                    class="bg-white rounded-4xl border border-slate-100 overflow-hidden shadow-sm transition-all hover:shadow-md">

                    {{-- HEADER SOAL --}}
                    <div class="bg-slate-50/80 border-b border-slate-100 p-6">

                        <div class="flex items-start gap-4">

                            <div
                                class="w-8 h-8 shrink-0 rounded-xl bg-[#071952] text-white flex items-center justify-center text-sm font-black shadow-lg shadow-blue-900/20">

                                {{ $question->no_soal }}

                            </div>

                            <div class="grow">

                                <div class="text-[15px] text-[#071952] font-bold leading-relaxed">
                                    {!! $question->deskripsi !!}
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ISI --}}
                    <div class="p-6 space-y-6">

                        @if ($question->subQuestions->count() > 0)
                            @foreach ($question->subQuestions as $q)
                                @php
                                    $ans = $answers->first(function ($item) use ($q) {
                                        return $item->sub_question_id == $q->id;
                                    });
                                @endphp

                                <div class="relative pl-6 border-l-2 border-slate-100 space-y-3">

                                    <div class="flex items-center gap-2">

                                        <span
                                            class="px-2 py-0.5 bg-slate-100 text-[#071952] text-[10px] font-black rounded tracking-tighter">

                                            {{ $q->label }}

                                        </span>

                                        <span class="text-sm text-slate-600 font-medium">
                                            {!! strip_tags($q->pertanyaan) !!}
                                        </span>

                                    </div>

                                    <div
                                        class="bg-slate-50 rounded-2xl p-4 text-sm text-slate-700 border border-slate-100 shadow-inner">

                                        <span
                                            class="block text-[10px] font-black uppercase text-slate-400 mb-1 tracking-widest">
                                            Jawaban Anda:
                                        </span>

                                        <p class="leading-relaxed">
                                            {{ $ans->jawaban ?? 'Belum dijawab' }}
                                        </p>

                                    </div>

                                </div>
                            @endforeach
                        @else
                            @php
                                $ans = $answers->where('question_id', $question->id)->first();
                            @endphp

                            <div class="space-y-3">

                                <div
                                    class="bg-slate-50 rounded-2xl p-5 text-sm text-slate-700 border border-slate-100 shadow-inner">

                                    <span
                                        class="block text-[10px] font-black uppercase text-slate-400 mb-1 tracking-widest">
                                        Jawaban Anda:
                                    </span>

                                    <p class="leading-relaxed">
                                        {{ $ans->jawaban ?? 'Belum dijawab' }}
                                    </p>

                                </div>

                            </div>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

        {{-- NAVIGASI --}}
        <div class="flex justify-between items-center mt-10 px-2">

            <a href="{{ route('siswa.course.lkpd.lanjutan', $case->course_id) }}"
                class="inline-flex items-center gap-2 px-5 py-2 text-xs
                bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Kembali
            </a>

            <a href="{{ route('siswa.course.reflection.index', $case->course_id) }}"
                class="inline-flex items-center gap-2 px-5 py-2 text-xs
                bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow transition-all">
                Lanjut ke Refleksi
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

    </div>
@endsection
