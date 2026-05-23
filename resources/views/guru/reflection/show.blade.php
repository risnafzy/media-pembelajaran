@extends('layouts.app')

@section('title', 'Detail Jawaban Refleksi')

@section('content')

    <div class="py-8 min-h-screen bg-app-bg">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('guru.nilai.rekap.refleksi') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#088395] mb-6 transition-colors group">

                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>

                </svg>

                Kembali ke Daftar Siswa

            </a>


            {{-- HEADER INFO SISWA --}}
            <div class="bg-[#071952] rounded-3xl shadow-lg overflow-hidden mb-8">

                <div class="px-8 py-8 flex items-center gap-5">

                    <div
                        class="w-16 h-16 rounded-2xl bg-[#37B7C3] text-white flex items-center justify-center font-black text-2xl shadow-inner">

                        {{ strtoupper(substr($answers->first()->student->name ?? 'S', 0, 1)) }}

                    </div>

                    <div>

                        <span
                            class="inline-block px-3 py-1 mb-2 text-[10px] font-bold text-[#071952] bg-[#EBF4F6] rounded-full uppercase tracking-wider">

                            Refleksi Pembelajaran

                        </span>

                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">

                            {{ $answers->first()->student->name ?? '-' }}

                        </h1>

                    </div>

                </div>

            </div>


            {{-- ================= EVALUASI ================= --}}
            <div class="space-y-6">

                <h2 class="text-lg font-bold text-yellow-600">Evaluasi</h2>

                @forelse ($answers->where('question.kategori','evaluasi') as $answer)
                    <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-6">

                        <h3 class="font-bold text-slate-800 mb-3">
                            {!! $answer->question->pertanyaan !!}
                        </h3>

                        <p class="text-slate-600 leading-relaxed">
                            {{ $answer->jawaban ?? 'Belum menjawab' }}
                        </p>

                    </div>
                @empty
                    <p class="text-sm text-slate-400 italic">Tidak ada jawaban evaluasi</p>
                @endforelse

            </div>


            {{-- ================= REFLEKSI ================= --}}
            <div class="space-y-6 mt-8">

                <h2 class="text-lg font-bold text-[#071952]">Refleksi</h2>

                @forelse ($answers->where('question.kategori','refleksi') as $answer)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                        <h3 class="font-bold text-slate-800 mb-3">
                            {!! $answer->question->pertanyaan !!}
                        </h3>

                        <p class="text-slate-600 leading-relaxed">
                            {{ $answer->jawaban ?? 'Belum menjawab' }}
                        </p>

                    </div>
                @empty
                    <p class="text-sm text-slate-400 italic">Tidak ada jawaban refleksi</p>
                @endforelse

            </div>

        </div>
    </div>

@endsection
