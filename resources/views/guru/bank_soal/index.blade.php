@extends('layouts.app')

@section('title', 'Bank Soal')

@section('content')
    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-800">
                        Manajemen Bank Soal
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola daftar soal untuk sesi Pretest dan Posttest siswa.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('guru.bank_soal.create', ['jenis' => 'pretest']) }}"
                        class="group inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Pretest
                    </a>

                    <a href="{{ route('guru.bank_soal.create', ['jenis' => 'posttest']) }}"
                        class="group inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Posttest
                    </a>
                </div>
            </div>


            {{-- ================= PRETEST SECTION ================= --}}
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-blue-500 rounded-full"></div>
                    <h2 class="text-lg font-bold text-slate-800">Soal Pretest</h2>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full ml-2">
                        {{ count($pretest) }} Soal
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($pretest as $index => $soal)
                        <div
                            class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md hover:border-blue-200 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <div class="flex items-start gap-3">
                                <span
                                    class="shrink-0 w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-500 font-semibold rounded-lg border border-slate-200 text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <p class="text-slate-700 font-medium leading-relaxed mt-1">
                                    {{ $soal->pertanyaan }}
                                </p>
                            </div>

                            <div
                                class="flex items-center gap-2 sm:ml-4 shrink-0 border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0">

                                <a href="{{ route('guru.bank_soal.edit', $soal->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit
                                </a>

                                <button type="button"
                                    onclick="openDeleteModal('{{ route('guru.bank_soal.delete', $soal->id) }}')"
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
                        <div
                            class="w-full flex flex-col items-center justify-center p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                            <div class="text-4xl mb-3">📝</div>
                            <p class="text-slate-500 font-medium text-center">Belum ada soal pretest yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- ================= POSTTEST SECTION ================= --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                    <h2 class="text-lg font-bold text-slate-800">Soal Posttest</h2>
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-0.5 rounded-full ml-2">
                        {{ count($posttest) }} Soal
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($posttest as $index => $soal)
                        <div
                            class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md hover:border-emerald-200 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <div class="flex items-start gap-3">
                                <span
                                    class="shrink-0 w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-500 font-semibold rounded-lg border border-slate-200 text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <p class="text-slate-700 font-medium leading-relaxed mt-1">
                                    {{ $soal->pertanyaan }}
                                </p>
                            </div>

                            <div
                                class="flex items-center gap-2 sm:ml-4 shrink-0 border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0">

                                <a href="{{ route('guru.bank_soal.edit', $soal->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit
                                </a>

                                <button type="button"
                                    onclick="openDeleteModal('{{ route('guru.bank_soal.delete', $soal->id) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
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
                        <div
                            class="w-full flex flex-col items-center justify-center p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                            <div class="text-4xl mb-3">📝</div>
                            <p class="text-slate-500 font-medium text-center">Belum ada soal posttest yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
