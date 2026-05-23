@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')

    {{-- ================= HEADER / HERO SECTION ================= --}}
    <div
        class="relative bg-slate-900 rounded-3xl p-6 md:p-8 mb-10 overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6">

        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-slate-800/50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-slate-800/30 blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center w-full gap-6">
            <div class="text-center md:text-left">
                <span
                    class="inline-block px-3 py-1 rounded-full bg-slate-800 text-slate-300 text-xs font-semibold tracking-wider uppercase border border-slate-700 mb-3">
                    Teacher Portal
                </span>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    Selamat Datang, {{ explode(' ', auth()->user()->name ?? 'Guru')[0] }}! 👨‍🏫
                </h1>
                <p class="text-slate-400 text-sm md:text-base max-w-md">
                    Pantau perkembangan siswa dan kelola materi pembelajaran Anda hari ini.
                </p>
            </div>

            <div class="flex flex-col items-center md:items-end shrink-0">
                <div
                    class="bg-transparent border border-slate-700 px-5 py-2.5 rounded-2xl flex flex-col items-center md:items-start">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status Pengajar</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                        <p class="text-slate-200 font-semibold text-sm">Aktif • 2025/2026</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= STATISTICS (4 Kolom) ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        {{-- Card 1: Total Siswa --}}
        <a href="{{ route('guru.user.index') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40 cursor-pointer">

            <div class="flex items-start justify-between mb-4">
                <div
                    class="bg-sky-50 text-sky-600 p-3 rounded-2xl group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Siswa Diampu
                </p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }}</h3>
            </div>
        </a>

        {{-- Card 2: Total Materi --}}
        <a href="{{ route('guru.course.index') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40 cursor-pointer">

            <div class="flex items-start justify-between mb-4">
                <div
                    class="bg-violet-50 text-violet-600 p-3 rounded-2xl group-hover:bg-violet-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Total Materi
                </p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalMateri ?? 0 }}</h3>
            </div>
        </a>

        {{-- Card 3: Tugas Masuk --}}
        <a href="{{ route('guru.nilai.rekap.lkpd') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40 cursor-pointer">

            <div class="flex items-start justify-between mb-4">
                <div
                    class="bg-amber-50 text-amber-600 p-3 rounded-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>

                <span
                    class="text-[10px] font-bold px-3 py-1.5 text-amber-600 border border-amber-100 rounded-full uppercase tracking-wider group-hover:bg-amber-50 transition-colors duration-300">
                    Pending
                </span>
            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Tugas Masuk
                </p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $tugasPending ?? 0 }}</h3>
            </div>
        </a>

        {{-- Card 4: Rata-rata Pretest --}}
        <a href="{{ route('guru.nilai.index') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40">

            <div class="flex items-start justify-between mb-4">
                <div
                    class="bg-blue-50 text-blue-600 p-3 rounded-2xl group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                    📘
                </div>
            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Rata-rata Pretest
                </p>
                <h3 class="text-3xl font-bold text-slate-800">
                    {{ $rataPretest ?? 0 }}
                </h3>
            </div>
        </a>

        {{-- Card 5: Rata-rata Posttest --}}
        <a href="{{ route('guru.nilai.index') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40">

            <div class="flex items-start justify-between mb-4">
                <div
                    class="bg-emerald-50 text-emerald-600 p-3 rounded-2xl group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                    📝
                </div>
            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Rata-rata Posttest
                </p>
                <h3 class="text-3xl font-bold text-slate-800">
                    {{ $rataPosttest ?? 0 }}
                </h3>
            </div>
        </a>

        {{-- Card 6: Peningkatan --}}
        <a href="{{ route('guru.nilai.index') }}"
            class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-40">

            <div class="flex items-start justify-between mb-4">

                <div
                    class="bg-purple-50 text-purple-600 p-3 rounded-2xl group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                    📈
                </div>

                @if (($peningkatan ?? 0) >= 0)
                    <span class="text-xs font-bold text-green-600">
                        +{{ $peningkatan }}
                    </span>
                @else
                    <span class="text-xs font-bold text-red-600">
                        {{ $peningkatan }}
                    </span>
                @endif

            </div>

            <div class="mt-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                    Peningkatan
                </p>

                <h3 class="text-3xl font-bold text-slate-800">
                    {{ $peningkatan ?? 0 }}
                </h3>
            </div>
        </a>

    </div>



    {{-- ================= MANAJEMEN KELAS ================= --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 px-2 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Kelas & Materi</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola materi dan ruang belajar siswa.</p>
            </div>
            <a href="{{ route('guru.course.index') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm transition-colors shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Materi Baru
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($managedCourses ?? [] as $course)
                <div
                    class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 group flex flex-col">
                    <span
                        class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full w-max uppercase tracking-wider mb-3">
                        {{ $course->kategori ?? 'UMUM' }}
                    </span>
                    <h3 class="font-bold text-xl text-slate-800 line-clamp-2">
                        {{ $course->nama }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-500 mt-4 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {{ $course->materi_count ?? 0 }} Sub Materi
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {{ $totalSiswa ?? 0 }} Siswa
                        </span>
                    </div>
                    <div class="mt-auto pt-6">
                        <a href="{{ route('guru.course.show', $course->id) }}"
                            class="block text-center w-full bg-slate-50 text-indigo-600 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-600 hover:text-white transition-colors duration-300">
                            Kelola Kelas
                        </a>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200 border-dashed">
                    <p class="text-slate-400 mb-2">Belum ada kelas atau materi yang dibuat.</p>
                    <a href="{{ route('guru.course.index') }}"
                        class="text-indigo-600 font-semibold hover:underline text-sm">Mulai buat materi pertama Anda</a>
                </div>
            @endforelse
        </div>
    </div>

@endsection
