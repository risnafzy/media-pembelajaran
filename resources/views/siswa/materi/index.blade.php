@extends('layouts.learning')
@section('title', 'Materi')
@section('page-title', 'Eksplorasi Materi')

@section('content')
    <div class="space-y-6">
        {{-- Header Instruksi: Lebih Compact --}}
        <div class="flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="w-12 h-12 shrink-0 bg-[#EBF4F6] rounded-xl flex items-center justify-center text-[#088395]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-sm font-black text-[#071952] uppercase tracking-tight leading-none mb-1">Eksplorasi Materi
                </h2>
                <p class="text-xs text-slate-500 font-medium">Modul: <span
                        class="text-[#088395] font-bold">{{ $course->nama }}</span></p>
            </div>
        </div>

        {{-- KONTEN MATERI --}}
        @if ($materi)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                {{-- Browser Bar --}}
                <div class="px-5 py-2.5 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/50"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-400/50"></div>
                        </div>
                        <div class="h-4 w-px bg-slate-200 mx-1"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            Bagian {{ $step }} / {{ $total }}
                        </span>
                    </div>
                    <span
                        class="text-[10px] font-mono text-[#088395] font-bold opacity-70">{{ $materi->judul ?? 'Reading_Mode' }}</span>
                </div>

                <div class="p-6 md:p-10">
                    <article
                        class="prose prose-slate text-sm max-w-none
                    prose-headings:text-[#071952] prose-headings:font-black prose-headings:tracking-tight prose-headings:mb-4
                    prose-p:text-slate-600 prose-p:leading-relaxed prose-p:text-sm prose-p:mb-4
                    prose-strong:text-[#088395] prose-strong:font-bold
                    prose-img:rounded-xl prose-img:shadow-md prose-img:my-6
                    prose-ul:text-sm prose-ul:mb-4
                    prose-code:bg-slate-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-[#071952] prose-code:text-xs">
                        {!! $materi->konten !!}
                    </article>
                </div>

                {{-- NAVIGASI FOOTER: Lebih Slim --}}
                <div class="px-6 py-4 bg-slate-50 border-t flex items-center justify-between rounded-b-2xl">

                    {{-- ================= KIRI (KEMBALI) ================= --}}
                    @if ($step > 1)
                        <a href="{{ route('siswa.course.materi', [$course->id, $step - 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2 text-xs
                              bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Kembali
                        </a>
                    @else
                        <a href="{{ route('siswa.course.lkpd.awal', [$course->id, $step - 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2 text-xs
                             bg-slate-500 hover:bg-slate-700 text-white font-bold rounded-lg shadow transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Kembali
                        </a>
                    @endif


                    {{-- ================= KANAN ================= --}}
                    @if ($step < $total)

                        {{-- NEXT MATERI --}}
                        <a href="{{ route('siswa.course.materi', [$course->id, $step + 1]) }}"
                            class="inline-flex items-center gap-2 px-5 py-2 text-xs
   bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow transition-all">

                            Selanjutnya

                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    @else
                        @if (!$progress->materi)
                            {{-- SELESAI --}}
                            <form action="{{ route('siswa.course.materi.selesai', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2 text-xs
                                     bg-green-600 hover:bg-green-800 text-white font-bold rounded-lg shadow transition-all active:scale-95">
                                    Selesai
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            {{-- SETELAH SELESAI (INI YANG KAMU MAU 🔥) --}}
                            <a href="{{ route('siswa.course.lkpd.lanjutan', $course->id) }}"
                                class="inline-flex items-center gap-2 px-5 py-2 text-xs
                                 bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow transition-all">
                                Lanjut ke LKPD
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        @endif

                    @endif

                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-[#071952] mb-1">Materi Sedang Disiapkan</h3>
                <p class="text-xs text-slate-500 font-medium">Sabar ya, materi akan segera muncul.</p>
            </div>
        @endif
    </div>
@endsection
