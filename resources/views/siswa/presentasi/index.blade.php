@extends('layouts.learning')

@section('title', 'Presentasi & Hasil Karya')
@section('page-title', 'Mengembangkan & Menyajikan Hasil Karya')

@section('content')
    {{-- Menggunakan Alpine.js untuk perpindahan Tab menyajikan karya kelas --}}
    <div x-data="{
        activeTab: '{{ filled($presentation->argumen_solusi) ? 'galeri' : 'karyaku' }}'
    }" class="max-w-4xl mx-auto space-y-6 pb-10 font-poppins">

        @php
            $finalScore = $score->score ?? null;
            $feedback = $score->feedback ?? null;
            $argumenSudahIsi = filled($presentation->argumen_solusi);
            $patternSudahIsi = filled($presentation->temuan_pola);
        @endphp

        {{-- HEADER TAHAPAN PBL --}}
        <div
            class="flex flex-col md:flex-row gap-4 items-center bg-white p-6 rounded-2xl border-l-4 border-l-[#088395] border-y border-r border-slate-200 shadow-sm mt-4">
            <div
                class="w-14 h-14 shrink-0 bg-[#EBF4F6] rounded-2xl flex items-center justify-center text-[#088395] shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>

            <div class="text-center md:text-left flex-1">
                <h1 class="text-xl font-black text-[#071952] uppercase tracking-tight leading-none mb-1">
                    kengembangkan & Menyajikan Karya
                </h1>
                <p class="text-xs text-slate-500 font-medium italic">
                    Kembangkan argumen solusimu, lalu sajikan dan diskusikan hasil pemrograman bersama siswa lain.
                </p>
            </div>
        </div>

        {{-- NAVIGASI TAB UTAMA --}}
        <div class="flex p-1 bg-slate-300 rounded-xl max-w-md mx-auto md:mx-0">
            <button @click="activeTab = 'karyaku'"
                :class="activeTab === 'karyaku' ? 'bg-white text-[#071952] shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                class="flex-1 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                Kembangkan Karyaku
            </button>
            <button @if ($argumenSudahIsi) @click="activeTab = 'galeri'" @endif
                :class="activeTab === 'galeri' ? 'bg-white text-[#071952] shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                class="flex-1 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2 {{ !$argumenSudahIsi ? 'opacity-50 cursor-not-allowed' : '' }}">
                Galeri Karya Kelas
            </button>
        </div>

        {{-- ==================== TAB 1: MENGEMBANGKAN KARYAKU ==================== --}}
        <div x-show="activeTab === 'karyaku'" class="space-y-6" x-transition>

            {{-- FORM MENGEMBANGKAN ARGUMEN PEMROGRAMAN --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 text-[#088395] font-bold text-sm uppercase tracking-wider">
                    <span></span> Langkah Pengembangan Eksperimen Solusi
                </div>
                <h3 class="text-base font-black text-[#071952] leading-tight">
                    Susun Narasi Presentasi & Kesimpulan LKPD Anda
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Sebelum mempresentasikan hasil program Python Anda di depan kelas, kemas dan kembangkan analisis Anda
                    terlebih dahulu. Jelaskan mengapa pemilihan operator atau method pada soal no 4 yang Anda gunakan adalah
                    solusi
                    yang paling tepat untuk masalah nyata ini.
                </p>

                {{-- Form Kirim Hasil Pengembangan ke Publik Kelas --}}
                <form method="POST" action="{{ route('siswa.course.lkpd.presentasi.store', $case->course_id) }}"
                    class="space-y-4 pt-2">
                    @csrf
                    {{-- Input 'tipe' atau 'form_type' disesuaikan dengan kebutuhan Controller Anda (disini saya sediakan tipe) --}}
                    <input type="hidden" name="tipe" value="argumen">
                    <input type="hidden" name="form_type" value="argumen">

                    <div>
                        <label class="block text-xs font-bold text-[#071952] uppercase mb-2">
                            Argumen Solusi Saya
                        </label>
                        <textarea name="argumen_solusi" rows="5" {{ filled($presentation->argumen_solusi) ? 'readonly' : 'required' }}
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
    {{ filled($presentation->argumen_solusi) ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ old('argumen_solusi', $presentation->argumen_solusi) }}</textarea>
                    </div>

                    @if (!filled($presentation->argumen_solusi))
                        <div class="mt-3">
                            <button type="submit"
                                class="inline-flex items-center  gap-2 px-5 py-2 text-xs bg-green-600 hover:bg-green-800 text-white font-bold rounded-xl shadow transition-all">
                                Simpan
                            </button>
                        </div>
                    @endif
                </form>
            </div>

            {{-- RANGKUMAN TRACKING JAWABAN SISWA --}}
            <div class="space-y-4">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest pl-2">
                    Review Kode Hasil Penyelidikan Anda:
                </div>
                @foreach ($case->questions as $question)
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <div class="bg-slate-50/80 border-b border-slate-100 p-5">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-7 h-7 shrink-0 rounded-lg bg-[#071952] text-white flex items-center justify-center text-xs font-black shadow-md">
                                    {{ $question->no_soal }}
                                </div>
                                <div class="grow text-xs text-[#071952] font-bold leading-relaxed">
                                    {!! $question->deskripsi !!}
                                </div>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">
                            @if ($question->subQuestions->count() > 0)
                                @foreach ($question->subQuestions as $q)
                                    @php
                                        $ans = $answers->first(fn($item) => $item->sub_question_id == $q->id);
                                    @endphp
                                    <div class="relative pl-4 border-l-2 border-slate-100 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-1.5 py-0.5 bg-slate-100 text-[#071952] text-[9px] font-black rounded">{{ $q->label }}</span>
                                            <span class="text-xs text-slate-600 font-medium">{!! strip_tags($q->pertanyaan) !!}</span>
                                        </div>
                                        <div
                                            class="bg-slate-900 text-green-400 rounded-xl p-3 font-mono text-xs shadow-inner">
                                            {{ $ans->jawaban ?? '# Belum dijawab' }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @php
                                    $ans = $answers->where('question_id', $question->id)->first();
                                @endphp
                                <div class="bg-slate-900 text-green-400 rounded-xl p-3 font-mono text-xs shadow-inner">
                                    {{ $ans->jawaban ?? '# Belum dijawab' }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ==================== TAB 2: GALERI KARYA KELAS ==================== --}}
        <div x-show="activeTab === 'galeri'" class="space-y-6" x-transition>

            {{-- PENJELASAN AKSI SOSIAL --}}
            <div class="bg-linear-to-r from-[#071952] to-[#088395] rounded-3xl p-6 text-white shadow-md">
                <h3 class="text-base font-black uppercase tracking-wide mb-1">Forum Presentasi & Uji Publik Solusi</h3>
                <p class="text-xs text-white/80 leading-relaxed font-light">
                    Gunakan ruang ini untuk membandingkan logika algoritma berpikir atau jawaban LKPD Anda dengan siswa lain.

                </p>
            </div>

            {{-- LIST KARYA TEMAN-TEMAN --}}
            <div class="space-y-4">
                @forelse($otherPresentations as $item)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <div>
                                <h4 class="text-xs font-bold text-[#071952]">
                                    {{ $item->user->name }}
                                </h4>
                                <p class="text-[10px] text-slate-400">
                                    Kasus : {{ $item->case->judul }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="text-xs font-bold text-slate-500 mb-2">
                                Argumen Solusi
                            </div>
                            <div
                                class="bg-linear-to-r from-slate-50 to-blue-50 border border-slate-200 rounded-2xl p-4 text-sm text-slate-700 leading-relaxed">
                                {{ $item->argumen_solusi }}
                            </div>

                            <div x-data="{ open: false }">

                                <button @click="open=!open"
                                    class="mt-3 text-xs font-bold text-blue-600 hover:text-blue-800">

                                    <span x-show="!open">
                                        Lihat Detail LKPD
                                    </span>

                                    <span x-show="open">
                                        Sembunyikan Detail LKPD
                                    </span>

                                </button>

                                <div x-show="open" x-transition class="mt-4 space-y-3">

                                    @foreach ($item->lkpdAnswers as $answer)
                                        <div class="border rounded-xl overflow-hidden">

                                            <div class="bg-slate-100 px-3 py-2">

                                                <div class="bg-slate-100 px-4 py-3">

                                                    <div class="text-xs font-bold text-[#071952] mb-2">

                                                        @if ($answer->question)
                                                            Soal {{ $answer->question->no_soal }}
                                                        @elseif($answer->subQuestion)
                                                            Soal {{ $answer->subQuestion->question->no_soal }}
                                                            ({{ $answer->subQuestion->label }})
                                                        @endif

                                                    </div>

                                                    <div class="text-xs text-slate-600 leading-relaxed">

                                                        @if ($answer->subQuestion)
                                                            {!! strip_tags($answer->subQuestion->pertanyaan) !!}
                                                        @elseif($answer->question)
                                                            {!! strip_tags($answer->question->deskripsi) !!}
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="bg-slate-900 text-green-400 p-3 text-xs font-mono">

                                                {{ $answer->jawaban }}

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-6 text-center text-slate-400 text-sm">
                        Belum ada karya siswa lain yang tersedia.
                    </div>
                @endforelse
            </div>

            <div class="bg-linear-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl p-5 shadow-sm">
                <h4 class="font-black text-[#071952] text-sm mb-3">
                    Studi Kasus Perbandingan
                </h4>

                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-semibold text-slate-500">Kasus Saya :</span>
                        <div class="font-bold text-[#071952]">
                            {{ $case->judul }}
                        </div>
                    </div>

                    <div>
                        <span class="font-semibold text-slate-500">Kasus Pembanding :</span>
                        <div class="font-bold text-[#071952]">
                            {{ $otherCase->judul ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM SUBMIT PATTERN RECOGNITION (FORM TERPISAH DAN MANDIRI) --}}
            <form method="POST" action="{{ route('siswa.course.lkpd.presentasi.store', $case->course_id) }}"
                class="mt-6">
                @csrf
                <input type="hidden" name="tipe" value="pattern">
                <input type="hidden" name="form_type" value="pattern">

                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                    <h4 class="font-bold text-[#071952] mb-2">
                       Analisis Kesamaan dan Perbedaan Solusi
                    </h4>
                    <p class="text-xs text-slate-600 mb-4">
                        Setelah mengamati hasil LKPD dan argumen solusi teman, pola apa yang Anda temukan?
                    </p>

                    <textarea name="temuan_pola" rows="5" {{ filled($presentation->temuan_pola) ? 'readonly' : 'required' }}
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
    {{ filled($presentation->temuan_pola) ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ old('temuan_pola', $presentation->temuan_pola) }}</textarea>

                    @if (!filled($presentation->temuan_pola))
                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan
                            </button>
                        </div>
                    @endif
                </div>
            </form>
            {{-- EVALUASI NILAI DARI GURU --}}
            <div
                class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col md:flex-row gap-5 items-stretch">
                <div
                    class="w-full md:w-48 shrink-0 bg-[#071952] rounded-xl p-5 flex flex-col items-center justify-center text-white border border-blue-800 shadow-md">
                    <div class="text-xs uppercase font-bold text-white/70 mb-1.5 tracking-wider">Nilai Dari Guru</div>
                    @if ($finalScore !== null)
                        <div class="text-4xl font-black text-[#37B7C3]">{{ $finalScore }}</div>
                    @else
                        <div
                            class="inline-flex items-center gap-1.5 mt-1 px-3 py-1.5 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-semibold rounded-lg shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Review Proses
                        </div>
                    @endif
                </div>

                <div class="flex-1 w-full flex flex-col justify-center">
                    <h3 class="text-sm font-black text-[#071952] mb-2 uppercase tracking-wide flex items-center gap-2">
                        Umpan Balik Guru terhadap Presentasi & Kesamaan Solusi
                    </h3>
                    @if ($feedback)
                        <div
                            class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs text-slate-700 leading-relaxed">
                            {{ $feedback }}
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 text-xs text-slate-400 italic">
                            Belum ada catatan evaluasi dari guru.
                        </div>
                    @endif
                </div>
            </div>
        </div>



        {{-- NAVIGASI BAWAH --}}
        <div class="flex justify-between items-center mt-10 px-2">
            <a href="{{ route('siswa.course.lkpd.lanjutan', $case->course_id) }}"
                class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Kembali ke Soal LKPD
            </a>

            @if ($patternSudahIsi)
                <div class="mt-4 text-right">
                    <a href="{{ route('siswa.course.reflection.index', $case->course_id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow">
                        Lanjut ke Refleksi Mandiri
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>

        @if (!$argumenSudahIsi)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-3 text-xs mt-4">
                Isi dan simpan Argumen Solusi terlebih dahulu untuk membuka Galeri Karya Kelas.
            </div>
        @elseif (!$patternSudahIsi)
            <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-xl p-3 text-xs mt-4">
                Isi dan simpan Pattern Recognition terlebih dahulu untuk melanjutkan ke Refleksi.
            </div>
        @endif

    </div>
@endsection
