@extends('layouts.app')

@section('title', 'Detail Jawaban Orientasi')

@section('head')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection

@section('content')
    <div class="py-8 min-h-screen bg-app-bg">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('guru.nilai.orientasi.rekap') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#088395] mb-6 transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Siswa
            </a>

            {{-- HEADER INFO SISWA --}}
            <div class="bg-[#071952] rounded-3xl shadow-lg overflow-hidden mb-8">
                <div class="px-8 py-8 flex items-center gap-5">

                    <div
                        class="w-16 h-16 rounded-2xl bg-[#37B7C3] text-white flex items-center justify-center font-black text-2xl shadow-inner">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <span
                            class="inline-block px-3 py-1 mb-2 text-[10px] font-bold text-[#071952] bg-[#EBF4F6] rounded-full uppercase tracking-wider">
                            Jawaban Orientasi
                        </span>

                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                            {{ $user->name }}
                        </h1>
                    </div>

                </div>
            </div>

            {{-- DAFTAR KARTU JAWABAN --}}
            <div class="space-y-6">

                @foreach ($orientasi->pertanyaan as $pertanyaan)
                    @php
                        $jawaban = $pertanyaan->jawaban->first();
                    @endphp

                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">

                        <h3 class="font-bold text-[#071952] mb-2">
                            {{ $pertanyaan->pertanyaan }}
                        </h3>

                        <p class="text-slate-600">
                            {{ $jawaban->jawaban ?? 'Belum menjawab' }}
                        </p>

                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
