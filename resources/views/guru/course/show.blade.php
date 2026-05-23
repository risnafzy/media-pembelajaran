@extends('layouts.app')

@section('title', 'Detail Course')

@section('content')
    <div class="py-8 min-h-screen bg-slate-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('guru.course.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-blue-600 mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Daftar Course
            </a>

            {{-- CONTAINER KARTU SATU KOLOM --}}
            <div class="space-y-6">

                {{-- ================= KARTU ORIENTASI ================= --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between p-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Orientasi Awal</h2>
                        </div>
                        @if (!$orientasi)
                            <a href="{{ route('guru.orientasi.create', $course->id) }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Orientasi
                            </a>
                        @endif
                    </div>

                    <div class="p-6">
                        @if ($orientasi)
                            <div class="mb-6">
                                <h3 class="text-sm font-bold text-slate-800 mb-2">Tujuan Pembelajaran</h3>
                                <div class="prose prose-sm max-w-none text-slate-600">{!! $orientasi->tujuan !!}</div>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-sm font-bold text-slate-800 mb-2">Deskripsi Masalah</h3>
                                <div class="prose prose-sm max-w-none text-slate-600">{!! $orientasi->isi !!}</div>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                                <a href="{{ route('guru.orientasi.edit', $orientasi->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit
                                </a>
                                <button type="button"
                                    onclick="openDeleteModal('{{ route('guru.orientasi.destroy', $orientasi->id) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-800 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-slate-500 text-sm">Belum ada orientasi berbasis masalah.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================= KARTU MATERI ================= --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    {{-- Header Kartu --}}
                    <div class="flex items-center justify-between p-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Daftar Materi</h2>
                        </div>
                        <a href="{{ route('guru.materi.create', $course->id) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tambah Materi
                        </a>
                    </div>

                    {{-- Isi Kartu (List) --}}
                    <div class="p-2">
                        @forelse ($materis as $materi)
                            <div
                                class="group flex items-center justify-between px-6 py-4 rounded-xl hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                    <span class="text-slate-700 font-medium group-hover:text-blue-700 transition-colors">
                                        {{ $materi->judul }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('guru.materi.edit', $materi->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('guru.materi.destroy', $materi->id) }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-800 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-slate-500 text-sm">Belum ada materi pembelajaran.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ================= KARTU LKPD ================= --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                    {{-- Header --}}
                    <div class="flex items-center justify-between p-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">LKPD (Studi Kasus)</h2>
                        </div>

                        <a href="{{ route('guru.lkpd.create', $course->id) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5  bg-blue-600 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg">
                            + Tambah LKPD
                        </a>
                    </div>

                    {{-- LIST --}}
                    <div class="p-2">
                        @forelse ($cases as $case)
                            <div  class="group flex items-center justify-between px-6 py-4 rounded-xl hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">

                                {{-- JUDUL --}}
                                <h3 class="font-bold text-slate-800 mb-1">
                                    {{ $case->judul }}
                                </h3>

                                {{-- AKSI --}}
                                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-slate-50">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('guru.lkpd.edit', $case->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('guru.lkpd.destroy', $case->id) }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-800 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-slate-500 text-sm">Belum ada LKPD.</p>
                            </div>
                        @endforelse
                    </div>

                </div>

                {{-- ================= KARTU REFLEKSI ================= --}}
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between p-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Refleksi Pembelajaran</h2>
                        </div>
                        <a href="{{ route('guru.reflection.create', $course->id) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tambah Pertanyaan
                        </a>
                    </div>

                    <div class="p-2">
                        @forelse ($reflectionQuestions as $index => $q)
                            <div
                                class="group px-6 py-4 rounded-xl hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                <div class="flex justify-between items-start">

                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="text-xs font-bold text-purple-600 uppercase tracking-wider">Refleksi
                                                {{ $index + 1 }}</span>
                                            <span
                                                class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-md text-[10px] font-bold">{{ ucfirst($q->kategori) }}</span>
                                        </div>
                                        <p class="text-slate-700 font-medium leading-relaxed">
                                            {!! $q->pertanyaan !!}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-2 ml-4 shrink-0 mt-2">
                                        <a href="{{ route('guru.reflection.edit', [$course->id, $q->id]) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('guru.reflection.destroy', [$course->id, $q->id]) }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-800 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-slate-500 text-sm">Belum ada pertanyaan refleksi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

