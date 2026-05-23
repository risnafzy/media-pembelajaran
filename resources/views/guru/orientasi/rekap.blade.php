@extends('layouts.app')

@section('title', 'Rekap Orientasi')

@section('content')
<div class="py-10 min-h-screen bg-app-bg">
    <div class="max-w-5xl mx-auto px-4">

        @forelse($courses as $course)
            @php
                // Logika pengambilan data tetap sama sesuai struktur Anda
                $users = $course->orientasi
                    ? $course->orientasi->pertanyaan->flatMap->jawaban->groupBy('user_id')
                    : collect();
            @endphp

            <div class="mb-12">
                {{-- HEADER AREA: Title & Info --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-10 bg-indigo-600 rounded-full"></div>
                        <div>
                            <h2 class="text-2xl font-bold text-[#071952] leading-tight">
                                {{ $course->nama }}
                            </h2>
                            <span class="inline-block mt-1 text-[10px] bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full font-bold uppercase tracking-wider">
                                {{ $users->count() }} Responden Orientasi
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TABLE CONTAINER --}}
                <div class="bg-white rounded-4xl border border-slate-100 shadow-sm overflow-hidden">
                    {{-- HEADER TABEL --}}
                    <div class="grid grid-cols-12 gap-4 px-8 py-5 bg-slate-50/50 border-b border-slate-100">
                        <div class="col-span-8">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Informasi Siswa</span>
                        </div>
                        <div class="col-span-4 text-right">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Aksi</span>
                        </div>
                    </div>

                    {{-- BODY TABEL --}}
                    <div class="divide-y divide-slate-50">
                        @forelse ($users as $userId => $items)
                            @php
                                $item = $items->first();
                                $userName = $item->user->name ?? 'Unknown User';
                            @endphp
                            <div class="grid grid-cols-12 gap-4 px-8 py-6 items-center hover:bg-slate-50/80 transition-colors">

                                {{-- USER COLUMN --}}
                                <div class="col-span-8 flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-linear-to-br from-indigo-50 to-blue-50 flex items-center justify-center font-bold text-indigo-600 text-sm border border-indigo-100 shadow-sm">
                                        {{ strtoupper(substr($userName, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#071952] text-base leading-none mb-1">
                                            {{ $userName }}
                                        </p>
                                        <p class="text-[11px] text-slate-400 font-medium italic">Selesai Mengerjakan Orientasi</p>
                                    </div>
                                </div>

                                {{-- ACTION COLUMN --}}
                                <div class="col-span-4 text-right">
                                    <a href="{{ route('guru.nilai.rekap.orientasi.show', [$course->id, $userId]) }}"
                                       class="inline-flex items-center px-6 py-2.5 bg-[#00A9FF] hover:bg-blue-600 text-white text-xs font-bold rounded-xl transition-all shadow-sm shadow-blue-100">
                                        Lihat Jawaban
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <p class="text-slate-400 text-sm italic">Belum ada jawaban orientasi untuk materi ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @empty
            {{-- EMPTY STATE --}}
            <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-600">Tidak Ada Data Orientasi</h3>
                <p class="text-slate-400 max-w-xs mx-auto mt-2">Belum ada course yang dikaitkan dengan tahap orientasi saat ini.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection
