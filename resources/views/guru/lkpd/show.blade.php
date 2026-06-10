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
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= HEADER ================= --}}
            <div class="bg-[#071952] rounded-3xl shadow-xl shadow-blue-900/10 overflow-hidden relative">
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
                {{-- STUDI KASUS INFO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200/60 px-6 py-4">
                        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#37B7C3]" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                            Studi Kasus: <span class="text-[#071952]">{{ $selectedCase->judul }}</span>
                        </h3>
                    </div>
                </div>

                {{-- ================= KONTAINER 1: JAWABAN LKPD & PRESENTASI ================= --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-bold text-[#071952] flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Bagian I: Lembar Kerja & Presentasi Siswa
                        </h2>
                        <span
                            class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full border border-indigo-100">Utama</span>
                    </div>

                    <div class="p-6 md:p-8 space-y-8">
                        {{-- LOOP JAWABAN LKPD --}}
                        @foreach ($selectedCase->questions as $q)
                            <div class="border-b border-slate-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center gap-3 mb-3">
                                    <span
                                        class="bg-slate-100 text-[#071952] text-xs font-bold px-3 py-1 rounded-lg border border-slate-200">
                                        Soal {{ $q->no_soal }}
                                    </span>
                                </div>

                                @if ($q->deskripsi)
                                    <div
                                        class="text-sm text-slate-600 mb-4 bg-slate-50 p-4 rounded-xl border border-slate-100 prose prose-slate max-w-none">
                                        {!! $q->deskripsi !!}
                                    </div>
                                @endif

                                <div class="space-y-4">
                                    @if ($q->subQuestions->count() > 0)
                                        @foreach ($q->subQuestions as $sub)
                                            @php $jawaban = $answers->firstWhere('sub_question_id', $sub->id); @endphp
                                            <div
                                                class="ml-2 md:ml-4 p-4 bg-white border border-slate-100 rounded-xl shadow-sm space-y-2">
                                                <div class="text-sm font-semibold text-slate-800 flex gap-2">
                                                    <span class="text-indigo-500">{{ $sub->label }}.</span>
                                                    <div>{!! $sub->pertanyaan !!}</div>
                                                </div>
                                                <div class="bg-slate-50 border-l-4 border-indigo-400 p-3 rounded-r-xl">
                                                    <p
                                                        class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">
                                                        Jawaban Siswa:</p>
                                                    <p class="text-sm text-slate-700 font-medium whitespace-pre-line">
                                                        {{ $jawaban->jawaban ?? 'Belum menjawab' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @php $jawaban = $answers->firstWhere('question_id', $q->id); @endphp
                                        <div class="ml-2 md:ml-4 bg-slate-50 border-l-4 border-indigo-400 p-3 rounded-r-xl">
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">
                                                Jawaban Siswa:</p>
                                            <p class="text-sm text-slate-700 font-medium whitespace-pre-line">
                                                {{ $jawaban->jawaban ?? 'Belum menjawab' }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{-- HASIL PRESENTASI (JIKA ADA) --}}
                        @if ($presentation)
                            <div class="mt-8 pt-6 border-t-2 border-dashed border-slate-100 space-y-4">
                                <h4
                                    class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Hasil Presentasi Siswa
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Argumen
                                            Solusi</label>
                                        <p class="text-sm text-slate-700 whitespace-pre-line">
                                            {{ $presentation->argumen_solusi ?: 'Belum diisi' }}</p>
                                    </div>
                                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pattern
                                            Recognition (Temuan Pola)</label>
                                        <p class="text-sm text-slate-700 whitespace-pre-line">
                                            {{ $presentation->temuan_pola ?: 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- FORM PENILAIAN UTAMA (NILAI AKHIR LKPD) --}}
                    <div class="bg-slate-50 border-t border-slate-100 p-6">
                        <form action="{{ route('guru.nilai.save') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="answer_id" value="{{ $answers->first()->id ?? '' }}">

                            <h3 class="text-sm font-bold text-[#071952] uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.381-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Evaluasi & Penilaian Bagian I
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nilai Akhir LKPD</label>
                                    <input type="number" name="score" min="0" max="100"
                                        value="{{ $existingScore->score ?? '' }}"
                                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-800"
                                        placeholder="0-100">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Komentar / Feedback
                                        Akhir</label>
                                    <textarea name="feedback" rows="1"
                                        class="w-full border border-slate-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="Berikan evaluasi tertulis kepada siswa...">{{ $existingScore->feedback ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-500/10 transition-all flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Nilai & Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ================= KONTAINER 2: KHUSUS ABSTRAKSI SISWA ================= --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="px-6 py-4 bg-amber-50/50 border-b border-amber-100 flex items-center justify-between">
                        <h2 class="text-base font-bold text-[#071952] flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Bagian II: Kemampuan Berpikir Komputasional (Abstraksi)
                        </h2>
                        <span
                            class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-bold rounded-full border border-amber-200">Indikator
                            CT</span>
                    </div>

                    @if ($abstraction)
                        <div class="p-6 md:p-8 space-y-6">
                            {{-- TAMPILAN JAWABAN ABSTRAKSI --}}
                            <div class="grid grid-cols-1 gap-5">
                                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                                    <label class="block text-xs font-bold text-[#071952] uppercase tracking-wider mb-2">
                                        1. Konsep Berdasarkan Materi yang Dipilih Siswa
                                    </label>
                                    <div
                                        class="bg-slate-50 border-l-4 border-amber-400 p-3 rounded-r-lg text-sm text-slate-700 whitespace-pre-line">
                                        {{ $abstraction->konsep ?: 'Belum diisi' }}
                                    </div>
                                </div>

                                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                                    <label class="block text-xs font-bold text-[#071952] uppercase tracking-wider mb-2">
                                        2. Bagian Kasus yang Diidentifikasi (Esensial)
                                    </label>
                                    <div
                                        class="bg-slate-50 border-l-4 border-amber-400 p-3 rounded-r-lg text-sm text-slate-700 whitespace-pre-line">
                                        {{ $abstraction->bagian_kasus ?: 'Belum diisi' }}
                                    </div>
                                </div>

                                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                                    <label class="block text-xs font-bold text-[#071952] uppercase tracking-wider mb-2">
                                        3. Informasi Pengalih / Tidak Relevan yang Diabaikan
                                    </label>
                                    <div
                                        class="bg-slate-50 border-l-4 border-amber-400 p-3 rounded-r-lg text-sm text-slate-700 whitespace-pre-line">
                                        {{ $abstraction->informasi_tidak_relevan ?: 'Belum diisi' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM VALIDASI ABSTRAKSI --}}
                        <div class="bg-amber-50/40 border-t border-amber-100 p-6">
                            <form action="{{ route('guru.nilai.abstraction.save') }}" method="POST" class="space-y-5">
                                @csrf
                                <input type="hidden" name="abstraction_id" value="{{ $abstraction->id }}">

                                

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                                    <div class="md:col-span-1">
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Validasi
                                            Abstraksi</label>
                                        <select name="status_validasi"
                                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 bg-white font-semibold text-slate-700">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="tepat" @selected(($abstraction->status_validasi ?? '') == 'tepat')>Tepat</option>
                                            <option value="sebagian_tepat" @selected(($abstraction->status_validasi ?? '') == 'sebagian_tepat')>Sebagian Tepat
                                            </option>
                                            <option value="kurang_tepat" @selected(($abstraction->status_validasi ?? '') == 'kurang_tepat')>Kurang Tepat</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Validasi &
                                            Feedback Khusus</label>
                                        <textarea name="feedback_guru" rows="1"
                                            class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400"
                                            placeholder="Tulis catatan perbaikan pemahaman konsep abstrak siswa...">{{ $abstraction->feedback_guru }}</textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs shadow-md shadow-amber-500/10 transition-all flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Simpan Validasi Abstraksi
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-8 text-center bg-white">
                            <div class="rounded-xl bg-amber-50 border border-amber-100 p-6 max-w-md mx-auto">
                                <svg class="w-8 h-8 text-amber-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <p class="text-sm font-semibold text-amber-800">Siswa belum mengisi lembar eksplorasi
                                    abstraksi materi.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                {{-- STATE EMPTY --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 flex flex-col items-center justify-center text-center">
                    <div
                        class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">Tidak Ada Data Jawaban</h3>
                    <p class="text-slate-400 text-xs mt-1">Belum ada rekaman pengerjaan untuk tugas LKPD ini.</p>
                </div>
            @endif

            {{-- ================= GLOBAL ACTION FOOTER ================= --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('guru.nilai.rekap.lkpd') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-sm transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Rekap Nilai
                </a>
            </div>

        </div>
    </div>
@endsection
