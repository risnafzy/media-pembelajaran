@extends('layouts.app')

@section('title', 'Alur Pembelajaran Course')

@section('content')
    {{-- Main Container: bg-slate-50 memberikan kontras tinggi untuk card putih --}}
    <div class="py-10 min-h-screen bg-slate-50 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang (Dibuat sangat soft agar tidak mengganggu fokus) --}}
        <div
            class="absolute top-0 right-0 -mt-20 -mr-20 w-120 h-120 bg-[#37B7C3] rounded-full blur-[120px] opacity-10 pointer-events-none">
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('siswa.course.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#088395] mb-8 transition-all bg-white px-6 py-2.5 rounded-full shadow-sm border border-slate-200 hover:shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Ruang Belajar
            </a>

            {{-- HEADER PETA PERJALANAN --}}
            <div
                class="mb-14 bg-white p-10 rounded-4xl shadow-sm border border-slate-200 flex flex-col sm:flex-row gap-8 items-center sm:items-start relative">
                {{-- Icon Header --}}
                <div
                    class="w-20 h-20 bg-[#EBF4F6] text-[#088395] rounded-2xl flex items-center justify-center shrink-0 border border-[#37B7C3]/10 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <span
                        class="inline-block px-4 py-1 bg-[#071952] text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-full mb-3">
                        Peta Misi Belajar
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black text-[#071952] tracking-tight mb-3">
                        {{ $course->nama }}
                    </h1>
                    <p class="text-slate-500 text-lg max-w-xl leading-relaxed font-medium">
                        Selesaikan setiap pos misi secara berurutan untuk melatih logika komputasionalmu! 🚀
                    </p>
                </div>
            </div>

            {{-- TIMELINE CONTAINER --}}
            <div class="relative ml-2 sm:ml-8 pb-12">
                {{-- Garis Utama Timeline (Solid & Tegas) --}}
                <div class="absolute top-8 bottom-8 left-5.75 w-0.5 bg-slate-200"></div>

                <div class="space-y-10">

                    {{-- POS 1: ORIENTASI --}}
                    <div class="relative pl-16 sm:pl-24 group">
                        {{-- Indikator Bulat di Garis --}}
                        <div
                            class="absolute left-0 top-6 w-12 h-12 bg-white rounded-2xl border-2 border-slate-200 shadow-sm flex items-center justify-center z-10 text-[#088395] group-hover:border-[#088395] transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                                </path>
                            </svg>
                        </div>

                        <a href="{{ route('siswa.course.orientasi.show', $course->id) }}"
                            class="block bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:border-[#088395] hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-[#088395] uppercase tracking-[0.2em] mb-1 block">Pos
                                        01</span>
                                    <h2 class="text-2xl font-bold text-[#071952]">Orientasi</h2>
                                    <p class="text-slate-500 mt-1 font-medium text-sm sm:text-base">Pahami tujuan misi kita
                                        sebelum mulai bertualang.</p>
                                </div>
                                <div
                                    class="text-slate-300 group-hover:text-[#088395] group-hover:translate-x-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- POS 2: LKPD --}}
                    <div class="relative pl-16 sm:pl-24 group">
                        <div
                            class="absolute left-0 top-6 w-12 h-12 bg-white rounded-2xl border-2 border-slate-200 shadow-sm flex items-center justify-center z-10 text-[#088395] group-hover:border-[#088395] transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>

                        <a href="{{ route('siswa.course.lkpd.index', $course->id) }}"
                            class="block bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:border-[#088395] hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-[#088395] uppercase tracking-[0.2em] mb-1 block">Pos
                                        02</span>
                                    <h2 class="text-2xl font-bold text-[#071952]">Lembar Kerja (LKPD)</h2>
                                    <p class="text-slate-500 mt-1 font-medium text-sm sm:text-base">Kerjakan tantangan
                                        analisis untuk melatih Computational Thinking.</p>
                                </div>
                                <div
                                    class="text-slate-300 group-hover:text-[#088395] group-hover:translate-x-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- POS 3: MATERI --}}
                    <div class="relative pl-16 sm:pl-24 group">
                        <div
                            class="absolute left-0 top-6 w-12 h-12 bg-white rounded-2xl border-2 border-slate-200 shadow-sm flex items-center justify-center z-10 text-[#088395] group-hover:border-[#088395] transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>

                        <a href="{{ route('siswa.course.materi', $course->id) }}"
                            class="block bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:border-[#088395] hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-[#088395] uppercase tracking-[0.2em] mb-1 block">Pos
                                        03</span>
                                    <h2 class="text-2xl font-bold text-[#071952]">Materi Pelajaran</h2>
                                    <p class="text-slate-500 mt-1 font-medium text-sm sm:text-base">Dalami materi Python di
                                        sini.</p>
                                </div>
                                <div
                                    class="text-slate-300 group-hover:text-[#088395] group-hover:translate-x-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- POS 4: BOSS STAGE (PYTHON RUNNER) --}}
                    <div class="relative pl-16 sm:pl-24 group">
                        <div
                            class="absolute left-0 top-6 w-12 h-12 bg-[#071952] rounded-2xl border border-[#071952] shadow-md flex items-center justify-center z-10 text-[#37B7C3]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>

                        <a href="{{ route('siswa.course.code-runner', $course->id) }}"
                            class="block bg-[#071952] p-8 rounded-3xl shadow-lg shadow-blue-900/20 hover:-translate-y-1 transition-all duration-300 border border-[#071952]">
                            <div class="flex items-center justify-between relative z-10">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-[#37B7C3] uppercase tracking-[0.2em] mb-1 block">Arena
                                        Praktik</span>
                                    <h2 class="text-2xl font-bold text-white font-mono tracking-tight">Python Code Runner
                                    </h2>
                                    <p class="text-slate-400 mt-1 font-medium text-sm sm:text-base">Implementasikan
                                        pemahamanmu dengan menulis kode nyata.</p>
                                </div>
                                <div class="text-[#37B7C3] group-hover:translate-x-1 transition-all">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- POS 5: REFLEKSI (GARIS AKHIR) --}}
                    <div class="relative pl-16 sm:pl-24 group">
                        <div
                            class="absolute left-0 top-6 w-12 h-12 bg-[#EBF4F6] rounded-2xl border-2 border-slate-200 shadow-sm flex items-center justify-center z-10 text-[#088395]">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>

                        <a href="{{ route('siswa.course.reflection.index', $course->id) }}"
                            class="block bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:border-[#088395] hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-[#088395] uppercase tracking-[0.2em] mb-1 block">Garis
                                        Akhir</span>
                                    <h2 class="text-2xl font-bold text-[#071952]">Refleksi Pembelajaran</h2>
                                    <p class="text-slate-500 mt-1 font-medium text-sm sm:text-base">Apa yang sudah kamu
                                        pelajari? Tuliskan di sini.</p>
                                </div>
                                <div
                                    class="text-slate-300 group-hover:text-[#088395] group-hover:translate-x-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
