@extends('layouts.app')

@section('title', 'Pretest')

@section('content')
    {{-- TAMBAHKAN STYLE INI UNTUK MEMAKSA HTML & BARIS BARU TETAP RAPIH --}}
    <style>
        .format-soal p { margin-bottom: 0.75rem; }
        .format-soal p:last-child { margin-bottom: 0; }
        .format-soal ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 0.75rem; }
        .format-soal ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 0.75rem; }
        .format-soal strong, .format-soal b { font-weight: 800; }
        .format-soal em, .format-soal i { font-style: italic; }
    </style>

    {{-- Container utama menggunakan h-screen dan overflow-hidden agar tidak ada scrollbar --}}
    <div class="h-full flex flex-col font-sans">
        <div class="max-w-6xl mx-auto px-4 w-full flex flex-col h-full py-4">

            {{-- HEADER - Dibuat lebih compact, sama dengan Posttest --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3 mb-3 flex justify-between items-center border-t-4 border-t-blue-600 shrink-0">
                <div>
                    <h1 class="text-lg font-bold text-slate-900 leading-none">Pretest</h1>
                    <p class="text-slate-500 text-xs mt-1">Mengukur Kemampuan Awal</p>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    {{-- Timer Badge --}}
                    <div id="timer-badge" class="flex-1 sm:flex-none bg-slate-50 border border-slate-200 px-3 py-1 rounded-lg text-center flex items-center justify-center gap-2 transition-all duration-300">
                        <svg id="timer-icon" class="w-4 h-4 text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span id="timer-display" class="font-bold text-slate-700 text-sm tracking-wider transition-colors">30:00</span>
                    </div>

                    {{-- Progress Badge --}}
                    <div class="bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg text-center">
                        <span class="block text-[9px] font-bold text-blue-600 uppercase">Progress</span>
                        <span class="block text-base font-black text-blue-700 leading-none">
                            <span id="current-question-number">1</span> / {{ count($soal) }}
                        </span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('siswa.pretest.submit') }}" id="pretest-form" class="flex flex-col flex-1 min-h-0">
                @csrf

                {{-- AREA SOAL - flex-1 dan overflow-y-auto agar jika teks sangat panjang, hanya area ini yang scroll --}}
                <div class="flex-1 min-h-0 relative overflow-hidden">
                    @foreach ($soal as $index => $s)
                        <div class="question-step h-full {{ $index == 0 ? 'flex' : 'hidden' }} flex-col" data-step="{{ $index }}">
                            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">

                                {{-- PERTANYAAN --}}
                                <div class="p-4 md:p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 shrink-0 bg-[#37B7C3] rounded-xl flex items-center justify-center text-[#071952] text-sm font-black mt-0.5">
                                            {{ $index + 1 }}
                                        </div>

                                        {{-- PERBAIKAN DI SINI: Menggunakan format-soal dan nl2br --}}
                                        <div class="format-soal text-sm md:text-base text-slate-800 leading-relaxed max-w-none w-full">
                                            {!! nl2br($s->pertanyaan) !!}
                                        </div>
                                    </div>
                                </div>

                                {{-- OPSI JAWABAN - Scrollable hanya di area ini jika opsi terlalu banyak --}}
                                <div class="p-4 md:p-6 space-y-3 overflow-y-auto flex-1">
                                    @foreach(['a', 'b', 'c', 'd', 'e'] as $opsi)
                                        @php $kolom = 'opsi_'.$opsi; @endphp
                                        @if($s->$kolom)
                                            <label class="group flex items-start p-4 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all has-checked:border-blue-500 has-checked:bg-blue-50">
                                                <div class="flex items-center h-5 mt-0.5">
                                                    <input type="radio" name="jawaban[{{ $s->id }}]" value="{{ strtoupper($opsi) }}"
                                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300">
                                                </div>
                                                <div class="ml-3 text-sm md:text-base text-slate-700 font-medium flex-1 leading-relaxed">
                                                    <span class="font-bold text-blue-700 mr-1">{{ strtoupper($opsi) }}.</span>

                                                    {{-- Opsi juga dirapikan --}}
                                                    <span class="format-soal inline">{!! nl2br($s->$kolom) !!}</span>
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- NAVIGASI - Fixed di bawah form --}}
                <div class="mt-3 py-3 border-t border-slate-200 flex items-center justify-between shrink-0">
                    <button type="button" id="btn-prev" class="hidden px-4 py-2 text-xs bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition-all flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Prev
                    </button>

                    <p id="error-msg" class="text-[10px] font-medium text-red-500 hidden animate-pulse">
                        *Pilih jawaban dulu!
                    </p>

                    <div class="flex gap-2 ml-auto">
                        <button type="button" id="btn-next" class="px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow transition-all flex items-center gap-2">
                            Selanjutnya
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <button type="submit" id="btn-submit" class="hidden px-5 py-2 text-xs bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-lg shadow-md transition-all items-center gap-2">
                            Kumpulkan
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- LOGIKA JAVASCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 0;
            const steps = document.querySelectorAll('.question-step');
            const totalSteps = steps.length;
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnSubmit = document.getElementById('btn-submit');
            const numberDisplay = document.getElementById('current-question-number');
            const errorMsg = document.getElementById('error-msg');
            const formPretest = document.getElementById('pretest-form');
            let isTimeUp = false;

            // --- LOGIKA TIMER ---
            let timeRemaining = 30  * 60; // 15 Menit
            const timerDisplay = document.getElementById('timer-display');
            const timerBadge = document.getElementById('timer-badge');
            const timerIcon = document.getElementById('timer-icon');

            const timerInterval = setInterval(function() {
                let minutes = Math.floor(timeRemaining / 60);
                let seconds = timeRemaining % 60;

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = minutes + ':' + seconds;

                // Ubah warna jadi merah & berkedip kalau sisa waktu <= 3 menit (180 detik)
                if (timeRemaining <= 180 && timeRemaining > 0) {
                    timerBadge.classList.remove('bg-slate-50', 'border-slate-200');
                    timerBadge.classList.add('bg-red-50', 'border-red-200', 'animate-pulse');
                    timerDisplay.classList.remove('text-slate-700');
                    timerDisplay.classList.add('text-red-600');
                    timerIcon.classList.remove('text-slate-500');
                    timerIcon.classList.add('text-red-500');
                }

                // Jika waktu habis
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    isTimeUp = true;
                    timerDisplay.textContent = "00:00";

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Waktu Habis!',
                            text: "Jawabanmu akan dikumpulkan secara otomatis.",
                            icon: 'warning',
                            confirmButtonText: 'Oke',
                            allowOutsideClick: false,
                            buttonsStyling: false,
                            width: '22em',
                            customClass: {
                                popup: 'rounded-3xl shadow-xl border border-slate-100 pb-2',
                                title: 'text-lg font-extrabold text-slate-800 pt-2',
                                htmlContainer: 'text-sm text-slate-500 mb-4',
                                actions: 'flex w-full px-6',
                                confirmButton: 'w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all'
                            }
                        }).then(() => {
                            formPretest.submit();
                        });
                    } else {
                        alert("Waktu habis! Jawaban otomatis dikumpulkan.");
                        formPretest.submit();
                    }
                }
                timeRemaining--;
            }, 1000);

            function updateUI() {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index !== currentStep);
                    step.classList.toggle('flex', index === currentStep);
                });

                numberDisplay.textContent = currentStep + 1;
                btnPrev.classList.toggle('hidden', currentStep === 0);

                if (currentStep === totalSteps - 1) {
                    btnNext.classList.add('hidden');
                    btnSubmit.classList.remove('hidden');
                    btnSubmit.classList.add('flex');
                } else {
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                    btnSubmit.classList.remove('flex');
                }
                errorMsg.classList.add('hidden');
            }

            function validateCurrentStep() {
                const currentInputs = steps[currentStep].querySelectorAll('input[type="radio"]');
                let isChecked = Array.from(currentInputs).some(input => input.checked);
                if (!isChecked) {
                    errorMsg.classList.remove('hidden');
                    return false;
                }
                return true;
            }

            btnNext.addEventListener('click', () => {
                if (validateCurrentStep() && currentStep < totalSteps - 1) {
                    currentStep++;
                    updateUI();
                }
            });

            btnPrev.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateUI();
                }
            });

            formPretest.addEventListener('submit', (e) => {
                e.preventDefault();

                if (!isTimeUp) {
                    if (!validateCurrentStep()) {
                        return;
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Kumpulkan sekarang?',
                            text: "Pastikan jawabanmu sudah benar!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Kumpulkan',
                            cancelButtonText: 'Cek Lagi',
                            reverseButtons: true,
                            buttonsStyling: false,
                            width: '22em',
                            customClass: {
                                popup: 'rounded-3xl shadow-xl border border-slate-100 pb-2',
                                title: 'text-lg font-extrabold text-slate-800 pt-2',
                                htmlContainer: 'text-sm text-slate-500 mb-4',
                                actions: 'flex w-full px-6 gap-3',
                                confirmButton: 'flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all',
                                cancelButton: 'flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold transition-all'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                formPretest.submit();
                            }
                        });
                    } else {
                        if(confirm("Kumpulkan jawaban sekarang?")) {
                            formPretest.submit();
                        }
                    }
                }
            });

            steps.forEach(step => {
                step.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.addEventListener('change', () => errorMsg.classList.add('hidden'));
                });
            });

            if (totalSteps > 0) {
                updateUI();
            }
        });
    </script>
@endsection
