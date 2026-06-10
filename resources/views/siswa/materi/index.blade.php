@extends('layouts.learning')
@section('title', 'Materi')
@section('page-title', 'Eksplorasi Materi')

@section('content')
    <div class="space-y-6">
        {{-- HEADER INTRUKSI --}}
        <div
            class="flex flex-col sm:flex-row gap-4 items-center bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="w-12 h-12 shrink-0 bg-[#EBF4F6] rounded-xl flex items-center justify-center text-[#088395]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div class="text-center sm:text-left space-y-0.5">
                <h2 class="text-sm font-black text-[#071952] uppercase tracking-wider">Eksplorasi Materi</h2>
                <p class="text-xs text-slate-500 font-medium">Modul: <span
                        class="text-[#088395] font-bold">{{ $course->nama }}</span></p>
            </div>
        </div>

        {{-- KONTEN MATERI --}}
        @if ($materi)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                {{-- Browser Bar --}}
                <div class="px-5 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-rose-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/70"></div>
                        </div>
                        <div class="h-4 w-px bg-slate-200 mx-1"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            Bagian {{ $step }} / {{ $total }}
                        </span>
                    </div>
                    <span class="text-[10px] font-mono text-[#088395] font-bold bg-[#EBF4F6] px-2 py-0.5 rounded">
                        {{ $materi->judul ?? 'Reading_Mode' }}
                    </span>
                </div>

                {{-- Artikel Materi --}}
                <div class="p-6 md:p-10 border-b border-slate-100">
                    <article
                        class="prose prose-slate text-slate-600 max-w-none text-sm md:text-base
                        prose-headings:text-[#071952] prose-headings:font-black prose-headings:tracking-tight
                        prose-p:leading-relaxed prose-p:mb-4
                        prose-strong:text-[#088395] prose-strong:font-bold
                        prose-img:rounded-2xl prose-img:shadow-sm prose-img:my-6 prose-img:mx-auto
                        prose-ul:list-disc prose-code:bg-slate-100 prose-code:px-2 prose-code:py-0.5 prose-code:rounded prose-code:text-[#071952] prose-code:text-xs">
                        {!! $materi->konten !!}
                    </article>
                </div>
                @php
                    $sudahIsi =
                        filled($abstraction->konsep ?? null) &&
                        filled($abstraction->bagian_kasus ?? null) &&
                        filled($abstraction->informasi_tidak_relevan ?? null);
                @endphp
                {{-- BAGIAN ABSTRAKSI (HANYA DI STEP TERAKHIR) --}}
                @if ($step == $total)
                    <div class="p-6 bg-slate-50/50 border-b border-slate-100">
                        <form action="{{ route('siswa.course.materi.abstraksi', $course->id) }}" method="POST"
                            class="bg-amber-50/60 border border-amber-200/80 rounded-2xl p-6 shadow-sm space-y-6">
                            @csrf
                            <div>
                                <h3 class="font-black text-[#071952] text-lg mb-1 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    Hubungkan Materi dengan Kasus
                                </h3>
                                <p class="text-xs text-slate-500 font-medium">Identifikasi konsep yang dapat membantu
                                    menyelesaikan kasus di bawah ini.</p>
                            </div>

                            <div class="space-y-5">

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-[#071952] uppercase mb-2">
                                        1. Konsep apa dari materi yang dapat membantu menyelesaikan kasus?
                                    </label>

                                    <textarea name="konsep" rows="4" {{ $sudahIsi ? 'readonly' : 'required' }}
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
        {{ $sudahIsi ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ old('konsep', $abstraction->konsep ?? '') }}</textarea>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-[#071952] uppercase mb-2">
                                        2. Bagian mana dari kasus yang menunjukkan bahwa konsep tersebut diperlukan?
                                    </label>

                                    <textarea name="bagian_kasus" rows="4" {{ $sudahIsi ? 'readonly' : 'required' }}
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
        {{ $sudahIsi ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ old('bagian_kasus', $abstraction->bagian_kasus ?? '') }}</textarea>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-[#071952] uppercase mb-2">
                                        3. Informasi apa yang tidak mempengaruhi pemilihan konsep atau solusi?
                                    </label>

                                    <textarea name="informasi_tidak_relevan" rows="4" {{ $sudahIsi ? 'readonly' : 'required' }}
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
        {{ $sudahIsi ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ old('informasi_tidak_relevan', $abstraction->informasi_tidak_relevan ?? '') }}</textarea>
                                </div>

                                @if (!$sudahIsi)
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-green-600 hover:bg-green-800 text-white font-bold rounded-xl shadow transition-all">
                                            Simpan Abstraksi
                                        </button>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3">

                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>

                                        <div>
                                            <p class="text-xs font-bold text-green-700">
                                                Jawaban tersimpan
                                            </p>
                                        </div>

                                    </div>
                                    <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">

    <h4 class="font-bold text-slate-700 mb-3">
        Validasi Guru
    </h4>

    @if(empty($abstraction->status_validasi))

        <div class="flex items-center gap-2 text-slate-500">

            <svg class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z"/>

            </svg>

            <span class="text-sm">
                Belum divalidasi oleh guru
            </span>

        </div>

    @else

        @php

            $badge = [
                'tepat' => [
                    'bg' => 'bg-green-50',
                    'border' => 'border-green-200',
                    'text' => 'text-green-700',
                    'label' => '✅ Tepat'
                ],
                'sebagian_tepat' => [
                    'bg' => 'bg-yellow-50',
                    'border' => 'border-yellow-200',
                    'text' => 'text-yellow-700',
                    'label' => '⚠️ Sebagian Tepat'
                ],
                'kurang_tepat' => [
                    'bg' => 'bg-red-50',
                    'border' => 'border-red-200',
                    'text' => 'text-red-700',
                    'label' => '❌ Kurang Tepat'
                ]
            ];

            $status = $badge[$abstraction->status_validasi] ?? null;

        @endphp

        @if($status)

            <div class="rounded-xl border {{ $status['border'] }} {{ $status['bg'] }} p-4">

                <div class="font-bold {{ $status['text'] }} mb-2">
                    {{ $status['label'] }}
                </div>

                @if($abstraction->feedback_guru)

                    <div class="bg-white/70 rounded-lg p-3 text-sm text-slate-700">
                        {{ $abstraction->feedback_guru }}
                    </div>

                @endif

            </div>

        @endif

    @endif

</div>
                                @endif

                            </div>

                        </form>
                    </div>
                @endif

                {{-- NAVIGASI FOOTER --}}
                <div class="px-6 py-4 bg-slate-50 flex items-center justify-between gap-4">
                    {{-- Tombol Kembali --}}
                    @if ($step > 1)
                        <a href="{{ route('siswa.course.materi', [$course->id, $step - 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Kembali
                        </a>
                    @else
                        <a href="{{ route('siswa.course.lkpd.awal', [$course->id, $step - 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl border border-slate-200 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Kembali
                        </a>
                    @endif

                    {{-- Tombol Kanan (Selanjutnya / Selesai) --}}
                    @if ($step < $total)
                        {{-- NEXT MATERI --}}
                        <a href="{{ route('siswa.course.materi', [$course->id, $step + 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-xs bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm hover:shadow transition-all">
                            Selanjutnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    @else
                        @if ($abstractionCompleted)
                            <form action="{{ route('siswa.course.materi.selesai', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow">
                                    Lanjut LKPD Lanjutan
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-xs bg-slate-200 text-slate-400 font-bold rounded-xl cursor-not-allowed border border-slate-300/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Lengkapi Abstraksi Dahulu
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @else
            {{-- STATE KOSONG / BELUM ADA MATERI --}}
            <div class="text-center py-20 bg-white rounded-2xl border border-slate-200/80 shadow-sm max-w-xl mx-auto px-6">
                <div
                    class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-slate-100">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-[#071952] mb-1">Materi Sedang Disiapkan</h3>
                <p class="text-xs text-slate-400 font-medium">Sabar ya, modul materi akan segera diperbarui oleh guru.</p>
            </div>
        @endif
    </div>
@endsection
