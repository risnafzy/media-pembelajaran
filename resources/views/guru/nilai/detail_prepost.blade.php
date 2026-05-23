@extends('layouts.app')

@section('content')
<div class="py-12 min-h-screen bg-slate-50">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Breadcrumb & Header --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <nav class="flex text-sm text-slate-500 mb-2">
                    <a href="{{ route('guru.nilai.index') }}" class="hover:text-blue-600 transition">Nilai</a>
                    <span class="mx-2">/</span>
                    <span class="text-slate-900 font-medium">Detail {{ ucfirst($jenis) }}</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Detail Hasil <span class="text-blue-600">{{ strtoupper($jenis) }}</span>
                </h2>
                <p class="text-slate-600 mt-1">
                    Siswa: <span class="font-semibold text-slate-800">{{ $student->name }}</span>
                </p>
            </div>

            {{-- Ringkasan Statistik Singkat --}}
            <div class="flex gap-3">
                <div class="bg-green-50 border border-green-100 px-4 py-2 rounded-lg text-center">
                    <p class="text-xs text-green-600 font-bold uppercase">Benar</p>
                    <p class="text-xl font-bold text-green-700">{{ $answers->where('benar', 1)->count() }}</p>
                </div>
                <div class="bg-red-50 border border-red-100 px-4 py-2 rounded-lg text-center">
                    <p class="text-xs text-red-600 font-bold uppercase">Salah</p>
                    <p class="text-xl font-bold text-red-700">{{ $answers->where('benar', 0)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12 text-center">No</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pertanyaan & Analisa Jawaban</th>
                            <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($answers as $index => $a)
                            <tr class="{{ $a->benar ? 'bg-white' : 'bg-red-50/30' }} hover:bg-slate-50 transition-colors">
                                <td class="p-4 text-center align-top">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 text-sm font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <div class="text-slate-800 font-medium mb-3 leading-relaxed">
                                        {!! $a->pertanyaan !!}
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                                        <div class="p-3 rounded-lg border {{ $a->benar ? 'bg-white border-slate-200' : 'bg-white border-red-200' }}">
                                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Jawaban Siswa</p>
                                            <p class="{{ $a->benar ? 'text-slate-700' : 'text-red-600 font-medium' }}">
                                                {{ $a->jawaban ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="p-3 rounded-lg border border-green-200 bg-green-50/50">
                                            <p class="text-[10px] uppercase font-bold text-green-600 mb-1">Jawaban Benar</p>
                                            <p class="text-green-700 font-medium italic">
                                                {{ $a->jawaban_benar }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-center align-middle">
                                    @if($a->benar)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold ring-1 ring-inset ring-green-600/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Benar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold ring-1 ring-inset ring-red-600/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            Salah
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-20">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-slate-500 font-medium">Tidak ada data jawaban untuk ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex items-center justify-between">
            <a href="{{ route('guru.nilai.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Nilai
            </a>
        </div>

    </div>
</div>
@endsection
