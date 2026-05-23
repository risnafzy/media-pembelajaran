@extends('layouts.app')

@section('title', 'Rekap Refleksi')

@section('content')
    <div class="py-8 min-h-screen bg-app-bg">

        <div class="max-w-5xl mx-auto px-4">

            {{-- LOOP COURSE --}}
            @forelse($courses as $course)

                <div class="mb-10">

                    {{-- TITLE --}}
                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>

                        <h2 class="text-xl font-bold text-[#071952] flex items-center gap-2">

                            {{ $course->nama }}

                            @php
                                $users = $course->reflectionQuestions->flatMap->answers->groupBy('student_id');
                            @endphp

                            <span
                                class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-semibold uppercase tracking-wider">
                                {{ $users->count() }} Data
                            </span>

                        </h2>

                    </div>



                    {{-- TABLE --}}
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

                        {{-- HEADER --}}
                        <div class="grid grid-cols-12 gap-4 px-8 py-4 bg-slate-50/50 border-b border-slate-100">

                            <div class="col-span-8">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                    Informasi Siswa
                                </span>
                            </div>

                            <div class="col-span-4 text-right">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                    Aksi
                                </span>
                            </div>

                        </div>



                        {{-- BODY --}}
                        <div class="divide-y divide-slate-50">

                            @forelse ($users as $studentId => $items)
                                @php
                                    $item = $items->first();
                                @endphp

                                <div
                                    class="grid grid-cols-12 gap-4 px-8 py-5 items-center hover:bg-slate-50 transition-colors">


                                    {{-- USER --}}
                                    <div class="col-span-8 flex items-center gap-4">

                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center font-bold text-blue-600 text-sm border border-blue-100">

                                            {{ strtoupper(substr($item->student->name, 0, 2)) }}

                                        </div>

                                        <span class="font-bold text-[#071952] text-sm">
                                            {{ $item->student->name }}
                                        </span>

                                    </div>



                                    {{-- BUTTON --}}
                                    <div class="col-span-4 text-right">

                                        <a href="{{ route('guru.nilai.rekap.refleksi.show', [$course->id, $studentId]) }}"
                                            class="inline-flex items-center px-5 py-2 bg-[#00A9FF] hover:bg-blue-600 text-white text-xs font-bold rounded-xl transition-all shadow-sm">

                                            Lihat Jawaban

                                        </a>

                                    </div>

                                </div>
                            @empty

                                <div class="p-8 text-center text-slate-400 text-sm italic">
                                    Belum ada jawaban refleksi untuk materi ini.
                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-slate-300">
                    <p class="text-slate-500 font-medium">
                        Belum ada data refleksi.
                    </p>
                </div>

            @endforelse

        </div>

    </div>
@endsection
