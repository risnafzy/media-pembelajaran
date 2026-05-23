@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

    {{-- HERO --}}
    <div
        class="relative bg-[#071952] rounded-xl p-6 mb-6 overflow-hidden flex flex-col md:flex-row justify-between items-center gap-5 shadow-sm">

        <div class="absolute top-0 right-0 w-52 h-52 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full bg-white/5 blur-2xl"></div>

        <div class="relative z-10 w-full flex flex-col md:flex-row justify-between items-center gap-5">

            {{-- TEXT --}}
            <div class="md:text-left">
                <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-white text-xs font-semibold mb-3 border border-white/10 backdrop-blur-sm">
                    Student Portal
                </span>

                <h1 class="text-xl sm:text-2xl font-semibold text-white mb-1">
                    Halo, {{ explode(' ', auth()->user()->name ?? 'Siswa')[0] }} 👋
                </h1>

                <p class="text-sm text-white/70 max-w-sm">
                    Siap melanjutkan pembelajaran hari ini?
                </p>
            </div>

            {{-- INFO --}}
            <div class="bg-white/10 border border-white/20 px-4 py-3 rounded-xl text-center md:text-left backdrop-blur-sm">
                <p class="text-xs text-white/70 mb-1">Tahun Ajaran</p>
                <p class="text-sm font-semibold text-white">2025/2026 Genap</p>
            </div>

        </div>
    </div>

    {{-- STATS --}}
    {{-- Grid disesuaikan: 1 kolom (HP) -> 2 kolom (Tablet) -> 3 kolom (Laptop) -> 5 kolom (Layar Lebar) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">

        {{-- CARD 1: AKTIF (TEMA BIRU) --}}
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col justify-between min-h-37.5">

            <div class="flex items-start justify-between mb-3">
                <div class="bg-blue-50 text-blue-600 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023" />
                    </svg>
                </div>
                <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded-md">Aktif</span>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $courseAktif }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Materi Dipelajari</p>
            </div>

        </div>

        {{-- CARD 2: PROGRESS (TEMA ORANYE) --}}
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col justify-between min-h-37.5">

            <div class="flex items-start justify-between mb-3">
                <div class="bg-orange-50 text-orange-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <span class="text-xs text-orange-500 font-semibold bg-orange-50 px-2 py-1 rounded-md">Progress</span>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">{{ $progress ?? 50 }}%</h3>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-2">
                    <div class="bg-orange-400 h-full rounded-full" style="width: {{ $progress ?? 50 }}%"></div>
                </div>
                <p class="text-xs text-slate-500 font-medium">Total Progress</p>
            </div>

        </div>

        {{-- CARD 3: SELESAI (TEMA HIJAU) --}}
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col justify-between min-h-37.5">

            <div class="flex items-start justify-between mb-3">
                <div class="bg-emerald-50 text-emerald-600 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z" />
                    </svg>
                </div>
                <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2 py-1 rounded-md">Selesai</span>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $tugas }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Tugas Terselesaikan</p>
            </div>

        </div>

        {{-- CARD 4: NILAI (TEMA UNGU) --}}
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col justify-between min-h-37.5">

            <div class="flex items-start justify-between mb-3">
                <div class="bg-purple-50 text-purple-600 p-2.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927l1.902 5.854h6.155l-4.979 3.618
                                                    1.902 5.854-4.98-3.618-4.979 3.618
                                                    1.902-5.854L2.993 8.781h6.155z" />
                    </svg>
                </div>
                <span class="text-xs text-purple-600 font-semibold bg-purple-50 px-2 py-1 rounded-md">Nilai</span>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-slate-800">
                    {{ $rataRataNilai }}
                </h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">
                    Rata-rata Nilai
                </p>
            </div>
        </div>

        {{-- CARD 5: PENINGKATAN (TEMA ROSE/MERAH MUDA) --}}
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-in-out flex flex-col justify-between min-h-37.5">

            <div class="flex items-start justify-between mb-3">
                <div class="bg-rose-50 text-rose-500 p-2.5 rounded-lg">
                    📈
                </div>

                @if (($peningkatan ?? 0) >= 0)
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                        +{{ $peningkatan }}
                    </span>
                @else
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">
                        {{ $peningkatan }}
                    </span>
                @endif
            </div>

            <div>
                <h3 class="text-2xl font-bold text-slate-800">
                    {{ $peningkatan }}
                </h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">
                    Peningkatan Nilai
                </p>
            </div>

        </div>

    </div>

@endsection
