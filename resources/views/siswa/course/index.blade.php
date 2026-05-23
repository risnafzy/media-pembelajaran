@extends('layouts.app')

@section('title', 'Course Materi')

@section('content')
<div class="py-8 bg-app-bg min-h-[calc(100vh-70px)]">
    <div class="max-w-6xl mx-auto px-4 sm:px-5 lg:px-6">

        {{-- HEADER --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-[#071952] tracking-tight">
                    Course Materi
                </h1>
                <p class="text-slate-600 text-sm mt-1">
                    Pilih materi, asah logikamu, dan mulai ngoding Python!
                </p>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
        <div class="mb-6 p-3 rounded-lg bg-[#EBF4F6] border border-[#37B7C3]/30 text-[#088395] text-sm font-medium flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-[#37B7C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($courses as $course)

            {{-- CARD --}}
            <div class="group relative bg-white border border-slate-200 rounded-xl p-5 flex flex-col min-h-45
                        transition-all duration-300 hover:-translate-y-1 hover:border-[#37B7C3] hover:shadow-xl">

                {{-- BACKGROUND ICON --}}
                <div class="absolute top-0 right-0 p-4 opacity-[0.03] group-hover:opacity-10 transition text-[#071952]">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>

                {{-- ICON --}}
                <div class="mb-4 relative z-10">
                    <div class="w-11 h-11 rounded-lg flex items-center justify-center
                                bg-[#EBF4F6] text-[#088395] group-hover:bg-[#37B7C3] group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                </div>

                {{-- TITLE --}}
                <div class="mb-2 relative z-10">
                    <h2 class="text-base font-semibold text-[#071952] leading-tight group-hover:text-[#088395]">
                        {{ $course->nama }}
                    </h2>
                    <span class="text-xs font-semibold text-[#37B7C3] uppercase tracking-wide">
                        Struktur Data
                    </span>
                </div>

                {{-- DESC --}}
                <p class="text-xs text-slate-600 mb-5 line-clamp-2 relative z-10 grow">
                    {{ $course->deskripsi ?: 'Pelajari konsep ini untuk meningkatkan cara berpikir komputasional dan pemecahan masalah.' }}
                </p>

                {{-- BUTTON --}}
                <div class="mt-auto relative z-10">
                    <a href="{{ route('siswa.course.orientasi.show', $course->id) }}"
                        class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5
                               text-sm font-semibold text-white bg-[#071952] rounded-lg
                               transition hover:bg-[#088395] hover:shadow-md">
                        Mulai
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            @empty

            {{-- EMPTY --}}
            <div class="col-span-full flex flex-col items-center justify-center py-14 text-center bg-white border border-dashed border-[#37B7C3]/30 rounded-xl">
                <div class="w-16 h-16 bg-[#EBF4F6] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[#088395]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-[#071952] mb-1">Materi Belum Tersedia</h3>
                <p class="text-sm text-slate-500 max-w-sm">
                    Guru kamu sedang menyiapkan materi. Coba kembali nanti ya!
                </p>
            </div>

            @endforelse

        </div>
    </div>
</div>
@endsection
