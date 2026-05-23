@extends('layouts.learning')

@section('title', 'Refleksi Pembelajaran')
@section('page-title', 'Refleksi')

@section('content')
    <div class="space-y-6">
        {{-- Header Instruksi --}}
        <div
            class="flex flex-col md:flex-row gap-4 items-center bg-linear-to-r from-[#088395]/10 to-transparent p-5 rounded-2xl border border-[#088395]/20">
            <div class="w-12 h-12 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-[#088395]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-base font-black text-[#071952] uppercase tracking-tight leading-none mb-1">Sudah Selesai
                    Belajar?</h2>
                <p class="text-xs text-slate-600 font-medium">Tuliskan rangkuman dan kesanmu mengenai modul <span
                        class="text-[#088395] font-bold">{{ $course->nama }}</span>.</p>
            </div>
        </div>

        <form id="form-refleksi" method="POST" action="{{ route('siswa.course.reflection.store', $course) }}"
            class="space-y-8">
            @csrf

            {{-- ================= RANGKUMAN (EVALUASI) ================= --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div>
                        <h3 class="text-sm font-black text-[#071952] uppercase">evaluasi pembelajaran</h3>
                    </div>
                </div>

                @foreach ($evaluasiQuestions as $index => $q)
                    <div
                        class="bg-white rounded-2xl p-5 border-2 border-orange-50 shadow-sm transition-all focus-within:border-orange-200">
                        <label class="block text-[#071952] text-sm mb-3">
                            {!! $q->pertanyaan !!}
                        </label>

                        <textarea name="jawaban[{{ $q->id }}]" rows="4" {{ $alreadyFilled ? 'readonly' : 'required' }}
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-400/5 transition-all outline-none resize-none shadow-inner
                                {{ $alreadyFilled ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ $answers[$q->id]->jawaban ?? '' }}</textarea>
                    </div>
                @endforeach
            </div>

            {{-- ================= REFLEKSI (KESAN) ================= --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div>
                        <h3 class="text-sm font-black text-[#071952] uppercase ">Refleksi Diri</h3>
                    </div>
                </div>

                @foreach ($refleksiQuestions as $index => $q)
                    <div
                        class="bg-white rounded-2xl p-5 border-2 border-slate-50 shadow-sm transition-all focus-within:border-[#37B7C3]/30">
                        <label class="block text-[#071952] text-sm mb-3">
                            {!! $q->pertanyaan !!}
                        </label>

                        <textarea name="jawaban[{{ $q->id }}]" rows="3" {{ $alreadyFilled ? 'readonly' : 'required' }}
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/5 transition-all outline-none resize-none shadow-inner
                            {{ $alreadyFilled ? 'bg-slate-50 text-slate-500 italic cursor-not-allowed' : '' }}">{{ $answers[$q->id]->jawaban ?? '' }}</textarea>
                    </div>
                @endforeach
            </div>

            {{-- NAVIGASI & SUBMIT --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('siswa.course.lkpd.presentasi', $course->id) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Kembali
                </a>

                @if (!$alreadyFilled)
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 text-xs bg-green-600 hover:bg-green-800 text-white font-black rounded-xl shadow-lg shadow-blue-900/20 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan & Selesaikan Modul
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                @else
                    <div
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 text-xs bg-green-50 border border-green-200 text-green-600 font-bold rounded-xl">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-9l-4 4-2-2" />
                        </svg>
                        Refleksi Telah Terkirim
                    </div>
                @endif
            </div>
        </form>
    </div>

    {{-- Muat library SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formRefleksi = document.getElementById('form-refleksi');

            if (formRefleksi) {
                formRefleksi.addEventListener('submit', function(e) {

                    @if (!$alreadyFilled)
                        e.preventDefault();

                        const form = this;

                        Swal.fire({
                            // Judul dengan HTML agar bisa dikustomisasi
                            title: '<h3 class="text-xl font-black text-[#071952] pt-2">Kirim Refleksi?</h3>',
                            html: '<p class="text-sm text-slate-500">Pastikan jawaban sudah sesuai. Aksi ini akan menyelesaikan modul.</p>',

                            icon: 'question',
                            iconColor: '#37B7C3', // Ubah warna icon jadi tosca/biru

                            showCancelButton: true,
                            confirmButtonText: 'Ya, Selesaikan',
                            cancelButtonText: 'Cek Kembali',

                            // MATIKAN styling bawaan SweetAlert
                            buttonsStyling: false,

                            // GUNAKAN Tailwind CSS untuk styling
                            customClass: {
                                // Perkecil ukuran popup dan buat membulat elegan
                                popup: 'rounded-3xl w-auto max-w-sm pb-6 border border-slate-100 shadow-2xl',
                                // Desain icon agar tidak terlalu raksasa
                                icon: 'border-0 scale-75 mt-4 mb-2',
                                // Beri jarak antar tombol
                                actions: 'gap-3 mt-4 flex w-full justify-center px-6',
                                // Desain tombol confirm (Hijau Tailwind)
                                confirmButton: 'w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all',
                                // Desain tombol cancel (Abu-abu lembut Tailwind)
                                cancelButton: 'w-full sm:w-auto px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    @endif
                });
            }
        });
    </script>
@endsection
