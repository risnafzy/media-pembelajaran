@extends('layouts.app')

@section('title', ucfirst($jenis))

@section('content')
    <div class="min-h-[calc(100vh-70px)] flex items-start justify-center bg-slate-50 relative px-3 pt-20">
        {{-- Background --}}
        <div class="absolute top-0 left-0 w-full h-32 bg-[#071952] rounded-b-2xl"></div>

        {{-- CARD --}}
        <div class="relative w-full max-w-sm">
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-5 text-center">

                @if ($sudah)

                    {{-- DESC --}}
                    <p class="text-sm text-slate-600 mb-5">
                        Kamu telah menyelesaikan
                        <span class="font-semibold text-slate-800">{{ strtoupper($jenis) }}</span>
                    </p>

                    {{-- STATUS --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-5">
                        <div class="grid grid-cols-2 gap-4">

                            <!-- STATUS -->
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Status</p>
                                <p class="text-sm font-semibold text-emerald-600">
                                    Selesai
                                </p>
                            </div>

                            <!-- NILAI -->
                            <div class="text-right mr-10">
                                <p class="text-xs text-slate-400 mb-1">Nilai</p>
                                <p class="text-lg font-bold text-[#071952]">
                                    {{ $nilai ?? '-' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <a href="{{ url('/siswa/' . $jenis . '/hasil') }}"
                        class="w-full mb-2 inline-flex justify-center items-center px-4 py-2.5
          bg-blue-600 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition">
                        Lihat Pembahasan
                    </a>
                @else
                    {{-- ICON --}}
                    <div
                        class="mx-auto w-14 h-14 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>

                    {{-- TITLE --}}
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">
                        {{ strtoupper($jenis) }}
                    </h2>

                    {{-- DESC --}}
                    <p class="text-sm text-slate-600 mb-5">
                        @if ($jenis == 'pretest')
                            Mengukur kemampuan awal sebelum memulai materi
                        @else
                            Mengukur pemahaman setelah mempelajari materi
                        @endif
                    </p>

                    {{-- INFO --}}
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-slate-50 border border-slate-200 p-3 rounded-lg text-center">
                            <p class="text-xs text-slate-400 mb-1">Durasi</p>
                            <p class="text-sm font-semibold text-slate-700">30 Menit</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 p-3 rounded-lg text-center">
                            <p class="text-xs text-slate-400 mb-1">Sifat</p>
                            <p class="text-sm font-semibold text-slate-700">Wajib</p>
                        </div>
                    </div>

                    @php
                        $startRoute = $jenis == 'pretest' ? url('/siswa/pretest/start') : url('/siswa/posttest/start');
                    @endphp

                    {{-- BUTTON --}}
                    <a href="{{ $startRoute }}"
                        class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5
                          bg-[#071952] hover:bg-[#088395] text-white text-sm font-semibold rounded-lg transition">
                        Mulai
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection
