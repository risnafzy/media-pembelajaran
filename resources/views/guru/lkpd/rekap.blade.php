@extends('layouts.app')

@section('title', 'Rekap LKPD')

@section('content')
<div class="py-10 min-h-screen bg-app-bg">
    <div class="max-w-5xl mx-auto px-4">

        @forelse($courses as $course)
            @php
                // ✅ FIX: support sub_question + question (tuple)
                $answers = \App\Models\LkpdAnswer::with([
                        'student',
                        'subQuestion.question.case',
                        'question.case'
                    ])
                    ->where(function ($query) use ($course) {

                        // dari sub_question (LIST)
                        $query->whereHas('subQuestion.question.case', function ($q) use ($course) {
                            $q->where('course_id', $course->id);
                        })

                        // dari question langsung (TUPLE)
                        ->orWhereHas('question.case', function ($q) use ($course) {
                            $q->where('course_id', $course->id);
                        });

                    })
                    ->get();

                $users = $answers->groupBy('student_id');
            @endphp

            <div class="mb-12">
                {{-- HEADER AREA --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">

                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-10 bg-blue-600 rounded-full"></div>
                        <div>
                            <h2 class="text-2xl font-bold text-[#071952] leading-tight">
                                {{ $course->nama }}
                            </h2>
                            <span class="inline-block mt-1 text-[10px] bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold uppercase tracking-wider">
                                {{ $users->count() }} Responden LKPD
                            </span>
                        </div>
                    </div>

                    {{-- BUTTON EXPORT --}}
                    @if($users->count() > 0)
                    <a href="{{ route('guru.lkpd.export', [$course->id, $course->id]) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-emerald-100 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-200 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export ke Excel
                    </a>
                    @endif
                </div>

                {{-- TABLE --}}
                <div class="bg-white rounded-4xl border border-slate-100 shadow-sm overflow-hidden">

                    {{-- HEADER --}}
                    <div class="grid grid-cols-12 gap-4 px-8 py-5 bg-slate-50/50 border-b border-slate-100">
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
                        @forelse ($users as $userId => $items)
                            @php
                                $user = $items->first()->student ?? null;
                            @endphp

                            <div class="grid grid-cols-12 gap-4 px-8 py-6 items-center hover:bg-slate-50/80 transition-colors">

                                <div class="col-span-8 flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-2xl bg-linear-to-br from-blue-50 to-indigo-50 flex items-center justify-center font-bold text-blue-600 text-sm border border-blue-100 shadow-sm">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                    </div>

                                    <div>
                                        <p class="font-bold text-[#071952] text-base leading-none mb-1">
                                            {{ $user->name ?? 'Unknown User' }}
                                        </p>
                                        <p class="text-[11px] text-slate-400 font-medium italic">
                                            Selesai mengerjakan LKPD
                                        </p>
                                    </div>
                                </div>

                                <div class="col-span-4 text-right">
                                    <a href="{{ route('guru.nilai.rekap.show', [$course->id, $userId]) }}"
                                       class="inline-flex items-center px-6 py-2.5 bg-[#00A9FF] hover:bg-blue-600 text-white text-xs font-bold rounded-xl transition-all shadow-sm shadow-blue-100">
                                        Lihat Jawaban
                                    </a>
                                </div>

                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <p class="text-slate-400 text-sm italic">
                                    Belum ada pengumpulan LKPD untuk materi ini.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        @empty
            <div class="bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-slate-200">
                <h3 class="text-lg font-bold text-slate-600">Tidak Ada Data</h3>
                <p class="text-slate-400 mt-2">
                    Belum ada course atau siswa belum mengerjakan.
                </p>
            </div>
        @endforelse

    </div>
</div>
@endsection
