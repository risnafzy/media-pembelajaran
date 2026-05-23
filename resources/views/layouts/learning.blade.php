<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StrucLearn')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            overflow: hidden;
        }

        .sidebar-gradient {
            background: #071952;
        }

        #sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            width: 14rem;
            /* Lebar sidebar 14rem */
        }

        #main-wrapper {
            margin-left: 14rem;
            /* Harus sama dengan lebar sidebar */
            width: calc(100% - 14rem);
            /* Harus sama dengan lebar sidebar */
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        /* --- LOGIKA DESKTOP --- */
        html.sidebar-closed #sidebar {
            transform: translateX(-14rem);
            /* Digeser sejauh lebar sidebar penuh */
        }

        html.sidebar-closed #main-wrapper {
            margin-left: 0;
            width: 100%;
        }

        /* --- LOGIKA MOBILE --- */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-14rem);
                /* Tersembunyi secara default */
            }

            html.sidebar-open #sidebar {
                transform: translateX(0);
                /* Muncul ke posisi awal */
            }

            #main-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body class="text-slate-800 antialiased relative">

    {{-- DITAMBAHKAN: Overlay Gelap untuk Mobile saat sidebar terbuka --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity"
        onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar-gradient text-white flex flex-col shadow-2xl">
        <div class="h-16 flex items-center px-6 shrink-0">
            <div class="flex items-center gap-3">
                <div class="bg-[#37B7C3] p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="text-base font-bold tracking-tight">Struc<span class="text-[#37B7C3]">Learn</span></span>
            </div>
        </div>

        <div class="flex-1 px-4 py-4">
            <a href="{{ route('siswa.course.index') }}"
                class="group flex items-center gap-3 px-4 py-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-[#37B7C3] hover:border-[#37B7C3] transition-all duration-300">
                <svg class="w-4 h-4 text-[#37B7C3] group-hover:text-white transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-xs font-semibold group-hover:text-white">Kembali</span>
            </a>
        </div>
    </aside>

    <div id="main-wrapper">
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 md:px-6 shrink-0">
            <div class="flex flex-col">
                <div class="flex h-14 items-center justify-between">
                    <div class="flex items-center gap-2 md:gap-4">
                        <button id="toggleSidebar"
                            class="p-2 rounded-lg hover:bg-slate-100 text-slate-400 transition-colors shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        <h2 class="font-bold text-sm text-slate-800 tracking-tight truncate">@yield('page-title', 'Materi Pembelajaran')</h2>
                    </div>

                    <div class="hidden sm:flex items-center gap-3">
                        <span
                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $progressPercent ?? 0 }}%
                            Progress</span>
                        <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-[#37B7C3] h-full transition-all duration-1000"
                                style="width: {{ $progressPercent ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Scrollable Navigasi Langkah untuk Mobile --}}
                <div
                    class="flex items-center justify-start md:justify-center gap-3 pb-2 overflow-x-auto whitespace-nowrap no-scrollbar border-t border-slate-50 pt-2 w-full">
                    @php
                        $steps = [
                            ['label' => 'Orientasi', 'key' => 'orientasi'],
                            ['label' => 'LKPD Awal', 'key' => 'lkpd_awal'],
                            ['label' => 'Bahan bacaan`', 'key' => 'materi'],
                            ['label' => 'LKPD Lanjutan', 'key' => 'lkpd_lanjutan'],
                            ['label' => 'Presentasi', 'key' => 'Presentasi'],
                            ['label' => 'Refleksi', 'key' => 'refleksi'],
                        ];
                        $active = $active ?? 'orientasi'; // default value
                    @endphp
                    @foreach ($steps as $index => $s)
                        <div
                            class="text-xs font-semibold px-2 {{ $active == $s['key'] ? 'text-[#071952] border-b-2 border-[#37B7C3]' : 'text-slate-400' }}">
                            {{ $s['label'] }}
                        </div>
                        @if (!$loop->last)
                            <div class="w-1 h-1 rounded-full bg-slate-200 shrink-0"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="max-w-5xl mx-auto w-full">
                <div class="content-card bg-white p-6 md:p-8 mb-4 rounded-xl shadow-sm border border-slate-100">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('toggleSidebar');
        const overlay = document.getElementById('sidebar-overlay'); // Tangkap elemen overlay

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                // Logika Mobile: Buka/Tutup Sidebar & Overlay
                html.classList.toggle('sidebar-open');
                overlay.classList.toggle('hidden');
            } else {
                // Logika Desktop: Buka/Tutup Sidebar biasa
                html.classList.toggle('sidebar-closed');
                const state = html.classList.contains('sidebar-closed') ? 'closed' : 'open';
                localStorage.setItem('sidebar-state', state);
            }
        }

        toggleBtn.addEventListener('click', toggleSidebar);

        // Jika diload di desktop dan statusnya closed
        if (localStorage.getItem('sidebar-state') === 'closed' && window.innerWidth > 768) {
            html.classList.add('sidebar-closed');
        }

        // Sembunyikan overlay otomatis jika ukuran layar dibesarkan
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                html.classList.remove('sidebar-open');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
