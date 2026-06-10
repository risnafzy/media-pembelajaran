@extends('layouts.learning')

@section('title', 'Orientasi Course')
@section('page-title', 'Orientasi')

@section('content')
    <div class="space-y-6">
        {{-- Header Section: Lebih Ringkas --}}
        <div class="flex flex-col md:flex-row gap-6 items-center bg-slate-50 p-6 rounded-3xl border border-slate-100">
            <div class="w-14 h-14 shrink-0 bg-[#EBF4F6] rounded-2xl flex items-center justify-center text-[#088395]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                    </path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#071952] tracking-tight uppercase">Analisis Orientasi</h2>
                <p class="text-sm text-slate-500 font-medium">Pelajari materi <span
                        class="text-[#088395] font-bold">{{ $course->nama }}</span> dan jawab pertanyaan di bawah.</p>
            </div>
        </div>

        {{-- Tujuan Pembelajaran --}}
        <div class="bg-white border-l-4 border-[#37B7C3] p-4 bg-slate-50/50 rounded-r-2xl">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2.5" />
                </svg>
                Tujuan Pembelajaran
            </h3>
            <div class="text-sm text-slate-600 whitespace-pre-line leading-relaxed prose-sm">
                {!! $orientasi->tujuan !!}
            </div>
        </div>

        {{-- Konten Utama (Materi) --}}
        <div class="bg-[#071952] rounded-3xl overflow-hidden shadow-lg">
            <div class="px-6 py-3 bg-white/5 border-b border-white/5 flex items-center justify-between">
                <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest">Materi_Orientasi.md</span>
                <div class="flex gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-red-500/50"></div>
                    <div class="w-2 h-2 rounded-full bg-yellow-500/50"></div>
                    <div class="w-2 h-2 rounded-full bg-green-500/50"></div>
                </div>
            </div>
            <div class="p-8 md:p-10 text-sm prose prose-invert prose-sm max-w-none text-slate-300">
                {!! $orientasi->isi !!}
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Form Pertanyaan --}}
        <form method="POST" action="{{ route('siswa.course.orientasi.simpanJawaban', $course->id) }}" class="space-y-4">
            @csrf
            @foreach ($orientasi->pertanyaan->sortBy('urutan') as $index => $p)
                <div
                    class="bg-white rounded-3xl p-6 border border-slate-200 group transition-all hover:border-[#37B7C3]/30 hover:bg-slate-50/30">
                    <div class="flex gap-5">
                        <div
                            class="w-8 h-8 shrink-0 bg-[#071952] text-white rounded-xl flex items-center justify-center text-sm font-black">
                            {{ $index + 1 }}
                        </div>
                        <div class="grow">
                            <label class="block text-[#071952] text-sm mb-4 tracking-tight leading-snug">
                                {{ $p->pertanyaan }}
                            </label>
                            <textarea name="jawaban[{{ $p->id }}]" rows="3"
                                {{ isset($jawabanSiswa[$p->id]) ? 'readonly' : 'required' }}
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700
                                focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-sm
                                {{ isset($jawabanSiswa[$p->id]) ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}"
                                placeholder="Tuliskan analisis Anda...">{{ $jawabanSiswa[$p->id]->jawaban ?? '' }}</textarea>

                        </div>

                    </div>
                </div>
            @endforeach

            @if ($jawabanSiswa->count() == $orientasi->pertanyaan->count())

                <div class="rounded-3xl border border-blue-200 bg-blue-50 p-6">

                    <h3 class="font-bold text-blue-800 mb-3">
                        💬 Umpan Balik Guru
                    </h3>

                    @if ($feedback)
                        <div class="text-sm text-blue-900 whitespace-pre-line">
                            {{ $feedback->komentar }}
                        </div>
                    @else
                        <div class="text-sm text-slate-500 italic">
                            Belum ada umpan balik dari guru.
                        </div>
                    @endif

                </div>

            @endif

            {{-- Tombol Navigasi --}}
            <div class="flex justify-between items-center pt-4">

                @if ($jawabanSiswa->count() < $orientasi->pertanyaan->count())
                    <div></div>

                    {{-- TOMBOL SIMPAN (TENGAH) --}}
                    <button type="submit"
                        class="mx-auto inline-flex items-center gap-2 px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800
            text-white font-bold rounded-lg shadow transition-all active:scale-95">

                        Simpan Jawaban
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" />
                        </svg>
                    </button>

                    <div></div>
                @else
                    {{-- KOSONG DI KIRI --}}
                    <div></div>

                    {{-- TOMBOL NEXT (KANAN) --}}
                    <a href="{{ route('siswa.course.lkpd.awal', $course->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800
            text-white font-bold rounded-lg shadow transition-all">

                        Selanjutnya
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2" />
                        </svg>
                    </a>
                @endif

            </div>
        </form>
    </div>
@endsection
