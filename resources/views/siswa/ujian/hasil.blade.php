@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4 md:p-6 space-y-6 font-sans pb-10">

        {{-- STYLE UNTUK MERAPIHKAN FORMAT SOAL --}}
        <style>
            .format-soal p {
                margin-bottom: 0.75rem;
            }

            .format-soal p:last-child {
                margin-bottom: 0;
            }

            .format-soal ul {
                list-style-type: disc;
                padding-left: 1.5rem;
                margin-bottom: 0.75rem;
            }

            .format-soal ol {
                list-style-type: decimal;
                padding-left: 1.5rem;
                margin-bottom: 0.75rem;
            }
        </style>

        {{-- KARTU SKOR TOTAL (Menggunakan standar warna Tailwind agar PASTI MUNCUL) --}}
        <div
            class="bg-linear-to-r from-blue-700 to-cyan-500 rounded-3xl p-6 md:p-8 shadow-xl text-white flex flex-col md:flex-row justify-between items-center relative overflow-hidden group mt-4">
            {{-- Aksen Visual --}}
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-20 -bottom-10 w-32 h-32 bg-black/10 rounded-full blur-xl"></div>

            <div class="relative z-10 text-center md:text-left mb-6 md:mb-0">
                <h2 class="font-black text-2xl md:text-3xl tracking-tight mb-1">Hasil {{ strtoupper($jenis) }}</h2>
                <p class="text-sm text-cyan-100 font-medium">Evaluasi jawaban dan perolehan nilai Anda</p>
            </div>

            <div
                class="relative z-10 bg-white/20 backdrop-blur-md border border-white/30 px-8 py-4 rounded-2xl flex items-center gap-4 shadow-inner">
                <div class="text-5xl font-black drop-shadow-md text-white">
                    {{ $nilai }}
                </div>
                <div class="flex flex-col justify-center border-l border-white/30 pl-4">
                    <span class="text-sm font-bold text-white tracking-widest uppercase">Skor</span>
                    <span class="text-xs font-medium text-cyan-50">Skala 100</span>
                </div>
            </div>
        </div>

        {{-- LIST JAWABAN & PEMBAHASAN --}}
        <div class="space-y-4">
            @foreach ($data as $i => $item)
                @php $isCorrect = $item->benar; @endphp

                <div
                    class="bg-white rounded-2xl border {{ $isCorrect ? 'border-green-200' : 'border-red-200' }} overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">

                    <div class="p-5 md:p-6">
                        <div class="flex items-start gap-4">
                            {{-- Nomor Soal --}}
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 shrink-0 rounded-xl flex items-center justify-center text-sm md:text-base font-black shadow-sm mt-0.5 {{ $isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $i + 1 }}
                            </div>

                            <div class="flex-1">
                                {{-- Teks Pertanyaan --}}
                                <div
                                    class="format-soal text-sm md:text-base text-slate-800 leading-relaxed max-w-none w-full mb-4">
                                    {!! nl2br($item->soal->pertanyaan) !!}

                                    <div class="mt-3 space-y-1 text-sm text-slate-700">

                                        @foreach (['a', 'b', 'c', 'd', 'e'] as $opsi)
                                            @php $field = 'opsi_'.$opsi; @endphp

                                            @if ($item->soal->$field)
                                                @php
                                                    $huruf = strtoupper($opsi);
                                                    $isUser = $item->jawaban == $huruf;
                                                    $isCorrectOption = $item->soal->jawaban_benar == $huruf;
                                                @endphp

                                                <div
                                                    class="
                px-3 py-2 rounded-lg border
                {{ $isCorrectOption ? 'bg-green-50 border-green-300 font-semibold' : '' }}
                {{ $isUser && !$isCorrectOption ? 'bg-red-50 border-red-300' : '' }}
            ">
                                                    <span class="font-bold">{{ $huruf }}.</span>
                                                    {{ $item->soal->$field }}
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>

                                {{-- Box Jawaban --}}
                                <div class="flex flex-col sm:flex-row gap-3">
                                    {{-- Jawaban User --}}
                                    <div class="flex-1 bg-slate-50 border border-slate-100 rounded-xl p-4">
                                        <span
                                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Jawaban
                                            Anda:</span>
                                        <p
                                            class="text-sm md:text-base font-bold {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item->jawaban }}
                                        </p>
                                    </div>

                                    {{-- Kunci Jawaban (Hanya Muncul Jika Salah) --}}
                                    @if (!$isCorrect)
                                        <div
                                            class="flex-1 bg-cyan-50 border border-cyan-100 rounded-xl p-4 relative overflow-hidden">
                                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyan-500"></div>
                                            <span
                                                class="block text-[10px] font-bold text-cyan-700 uppercase tracking-wider mb-1 pl-2">Kunci
                                                Jawaban:</span>
                                            <p class="text-sm md:text-base font-bold text-blue-900 pl-2">
                                                {{ $item->soal->jawaban_benar }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Bar (Status Text) --}}
                    <div class="bg-slate-50 border-t border-slate-100 px-5 py-3 flex items-center justify-end">
                        {!! $isCorrect
                            ? '<span class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-green-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Benar</span>'
                            : '<span class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg> Salah</span>' !!}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="mt-8 pt-6 border-t border-slate-200 flex justify-start">
            <a href="{{ route('siswa.' . $jenis) }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm bg-white border-2 border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-all active:scale-95 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

    </div>
@endsection
