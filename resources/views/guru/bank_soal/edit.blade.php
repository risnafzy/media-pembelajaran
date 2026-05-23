@extends('layouts.app')

@section('content')
    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Edit Soal {{ ucfirst($soal->jenis) }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Lakukan perubahan pada pertanyaan atau opsi jawaban di bawah ini.
                    </p>
                </div>

                <a href="{{ route('guru.bank_soal.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <form method="POST" action="{{ route('guru.bank_soal.update', $soal->id) }}" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label for="pertanyaan" class="block text-sm font-bold text-slate-700 mb-2">
                            Pertanyaan
                        </label>
                        <textarea id="pertanyaan" name="pertanyaan" rows="4" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none resize-y placeholder:text-slate-400"
                            placeholder="Tuliskan pertanyaan di sini...">{{ $soal->pertanyaan }}</textarea>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    <div class="space-y-4 mb-8">
                        <h3 class="text-sm font-bold text-slate-700 mb-3">Pilihan Jawaban</h3>

                        <div class="flex items-start gap-3">
                            <div
                                class="shrink-0 w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-100 shadow-sm">
                                A</div>
                            <input type="text" name="opsi_a" value="{{ $soal->opsi_a }}" required
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="shrink-0 w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-100 shadow-sm">
                                B</div>
                            <input type="text" name="opsi_b" value="{{ $soal->opsi_b }}" required
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="shrink-0 w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-100 shadow-sm">
                                C</div>
                            <input type="text" name="opsi_c" value="{{ $soal->opsi_c }}" required
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="shrink-0 w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-100 shadow-sm">
                                D</div>
                            <input type="text" name="opsi_d" value="{{ $soal->opsi_d }}" required
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="shrink-0 w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-100 shadow-sm">
                                E</div>
                            <input type="text" name="opsi_e" value="{{ $soal->opsi_e }}" required
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none">
                        </div>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    <div class="mb-8">
                        <label for="jawaban_benar" class="block text-sm font-bold text-slate-700 mb-2">
                            Kunci Jawaban Benar
                        </label>
                        <select id="jawaban_benar" name="jawaban_benar" required
                            class="w-full sm:w-1/2 rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all outline-none cursor-pointer">
                            <option value="A" {{ $soal->jawaban_benar == 'A' ? 'selected' : '' }}>Opsi A</option>
                            <option value="B" {{ $soal->jawaban_benar == 'B' ? 'selected' : '' }}>Opsi B</option>
                            <option value="C" {{ $soal->jawaban_benar == 'C' ? 'selected' : '' }}>Opsi C</option>
                            <option value="D" {{ $soal->jawaban_benar == 'D' ? 'selected' : '' }}>Opsi D</option>
                            <option value="E" {{ $soal->jawaban_benar == 'E' ? 'selected' : '' }}>Opsi E</option>
                        </select>
                    </div>

                    <div class="flex justify-end pt-5 border-t border-slate-100">
                        <button type="submit"
                            class="group inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5 transition-transform group-hover:rotate-180 duration-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
