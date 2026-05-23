@extends('layouts.learning')

@section('title', 'LKPD Lanjutan')
@section('page-title', 'LKPD Lanjutan')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="overflow-hidden bg-[#071952] rounded-2xl border border-blue-900 shadow-lg relative">
            <div class="px-5 py-2.5 bg-white/5 border-b border-white/5 flex items-center justify-between">
                <span class="text-[9px] font-mono text-slate-400 uppercase tracking-widest">
                    LKPD_Lanjutan.md
                </span>

                <div class="flex gap-1">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#FF5F56]/50"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-[#27C93F]/50"></div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h2 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
                    <span class="text-[#37B7C3]">#</span>
                    Bagian B: Penerapan Konsep
                </h2>

                <p class="text-sm text-slate-300">
                    Selesaikan soal lanjutan (2–5) pada modul
                    <span class="text-[#37B7C3] font-semibold">
                        {{ $course->nama ?? 'ini' }}
                    </span>
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('siswa.course.lkpd.store', $course->id) }}">
            @csrf

            {{-- ================= STATUS ISI ================= --}}
            @php
                $idsLanjutan = $selectedCase
                    ? $selectedCase->questions
                        ->where('no_soal', '>=', 2)
                        ->flatMap(fn($q) => $q->subQuestions->count() > 0
                            ? $q->subQuestions->pluck('id')
                            : collect([$q->id])
                        )
                    : collect();

                $jawabanKeys = collect($jawaban)->keys();

                $sudahIsi = $idsLanjutan->diff($jawabanKeys)->isEmpty();
            @endphp

            @if ($selectedCase)

                @foreach ($selectedCase->questions->where('no_soal', '>=', 2) as $q)
                    <div class="bg-white rounded-2xl p-5 border shadow-sm">
                        <div class="flex gap-4">

                            {{-- NOMOR SOAL --}}
                            <div class="w-8 h-8 bg-[#071952] text-white rounded-xl flex items-center justify-center font-bold">
                                {{ $q->no_soal }}
                            </div>

                            <div class="flex-1">

                                {{-- PERTANYAAN UTAMA --}}
                                <div class="mb-4 text-sm font-semibold text-[#071952]">
                                    {!! $q->deskripsi !!}
                                </div>

                                <div class="space-y-4">

                                    {{-- ================= SUB / LANGSUNG ================= --}}
                                    @if ($q->subQuestions->count() > 0)

                                        {{-- SUB QUESTION --}}
                                        @foreach ($q->subQuestions as $sub)
                                            <div class="space-y-2">

                                                <div class="flex gap-2 text-sm text-slate-600">
                                                    <span class="w-5 h-5 bg-[#EBF4F6] text-[#088395] flex items-center justify-center text-xs font-bold rounded">
                                                        {{ $sub->label }}
                                                    </span>

                                                    <div>{!! $sub->pertanyaan !!}</div>
                                                </div>

                                                <textarea name="jawaban_sub[{{ $sub->id }}]" rows="3"
                                                    {{ $sudahIsi ? 'readonly' : 'required' }}
                                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700
                                                    focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-sm
                                                    {{ $sudahIsi ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}"
                                                    placeholder="Ketik jawaban untuk poin {{ $sub->label }}...">{{ $jawaban[$sub->id] ?? '' }}</textarea>

                                            </div>
                                        @endforeach

                                    @else

                                        {{-- TANPA SUB --}}
                                        <div class="space-y-2">

                                            <div class="text-sm text-slate-600">
                                                Jawaban:
                                            </div>

                                            <textarea name="jawaban_q[{{ $q->id }}]" rows="3"
                                                {{ $sudahIsi ? 'readonly' : 'required' }}
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700
                                                focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-sm
                                                {{ $sudahIsi ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}"
                                                placeholder="Ketik jawaban Anda di sini...">{{ $jawaban[$q->id] ?? '' }}</textarea>

                                        </div>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif

            {{-- ================= NAVIGASI ================= --}}
            @php
                $totalSub = $idsLanjutan->count();
                $jawabanTerisi = $idsLanjutan->intersect($jawabanKeys)->count();
            @endphp

            <div class="flex justify-between items-center pt-6 mt-4 border-t border-slate-100">

                <a href="{{ route('siswa.course.materi', $course->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                    ← Kembali ke Materi
                </a>

                @if ($jawabanTerisi < $totalSub)
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-green-600 hover:bg-green-800 text-white font-bold rounded-lg shadow transition-all">
                        Simpan Jawaban
                    </button>
                @else
                    <a href="{{ route('siswa.course.lkpd.presentasi', $course->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow transition-all">
                        Lanjut ke Presentasi →
                    </a>
                @endif

            </div>

        </form>

    </div>
@endsection
