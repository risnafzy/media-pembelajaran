@extends('layouts.app')

@section('content')
    <div class="py-10 min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                        Rekap Nilai Siswa
                    </h1>

                </div>

                <div class="flex gap-3">

                    {{-- Export Pretest --}}
                    <a href="{{ route('guru.nilai.export', 'pretest') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-600/30 hover:-translate-y-0.5 transition-all duration-300">

                        Export Pretest
                    </a>

                    {{-- Export Posttest --}}
                    <a href="{{ route('guru.nilai.export', 'posttest') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-green-600/30 hover:-translate-y-0.5 transition-all duration-300">

                        Export Posttest
                    </a>

                </div>
            </div>


            {{-- ================= TABEL PRETEST ================= --}}
            <div class="mb-12">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-7 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-slate-800">Hasil Nilai Pretest</h2>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full ml-2">
                        {{ $nilai->where('jenis', 'pretest')->count() }} Data
                    </span>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-bold">
                                    <th class="px-6 py-4">Informasi Siswa</th>
                                    <th class="px-6 py-4 text-center">Jawaban Benar</th>
                                    <th class="px-6 py-4 text-center">Total Soal</th>
                                    <th class="px-6 py-4 text-center">Nilai Akhir</th>
                                    <th class="px-6 py-4 text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                                @forelse($nilai->where('jenis', 'pretest') as $n)
                                    <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <img class="w-9 h-9 rounded-full border-2 border-white shadow-sm"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($n->nama) }}"
                                                    alt="Avatar">
                                                <span class="font-bold text-slate-800">
                                                    {{ $n->nama }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">{{ $n->jumlah_benar }}</td>
                                        <td class="px-6 py-4 text-center">{{ $n->total_soal }}</td>
                                        <td class="px-6 py-4 text-center">
                                            {{ round($n->nilai) }}
                                        </td>

                                        {{-- 🔥 TOMBOL LIHAT --}}
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('guru.nilai.detail.prepost', [$n->id, $n->jenis]) }}"
                                                class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                                Lihat
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- ================= TABEL POSTTEST ================= --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-7 bg-green-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-slate-800">Hasil Nilai Posttest</h2>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-0.5 rounded-full ml-2">
                        {{ $nilai->where('jenis', 'posttest')->count() }} Data
                    </span>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-bold">
                                    <th class="px-6 py-4">Informasi Siswa</th>
                                    <th class="px-6 py-4 text-center">Jawaban Benar</th>
                                    <th class="px-6 py-4 text-center">Total Soal</th>
                                    <th class="px-6 py-4 text-center">Nilai Akhir</th>
                                    <th class="px-6 py-4 text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nilai->where('jenis', 'posttest') as $n)
                                    <tr>
                                        <td class="px-6 py-4">{{ $n->nama }}</td>
                                        <td class="px-6 py-4 text-center">{{ $n->jumlah_benar }}</td>
                                        <td class="px-6 py-4 text-center">{{ $n->total_soal }}</td>
                                        <td class="px-6 py-4 text-center">{{ round($n->nilai) }}</td>

                                        {{-- 🔥 TOMBOL LIHAT --}}
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('guru.nilai.detail.prepost', [$n->id, $n->jenis]) }}"
                                                class="px-3 py-1 bg-green-500 text-white rounded-lg text-xs hover:bg-green-600">
                                                Lihat
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
