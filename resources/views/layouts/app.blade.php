<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StrucLearn')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                /* Digeser sejauh lebar sidebar penuh */
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

    <script>
        if (localStorage.getItem('sidebar-state') === 'closed' && window.innerWidth > 768) {
            document.documentElement.classList.add('sidebar-closed');
        }
    </script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
</head>

<body class="text-slate-800 antialiased">

    {{-- Overlay Gelap untuk Mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity"
        onclick="toggleSidebar()"></div>

    <div class="flex h-screen overflow-hidden">

        <aside id="sidebar" class="sidebar-gradient text-white flex flex-col shadow-2xl">
            <div class="h-16 flex items-center px-4 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="bg-[#088395] p-1.5 rounded-lg shadow-lg shadow-cyan-900/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-base font-bold tracking-tight text-white">Struc<span
                            class="text-[#37B7C3]">Learn</span></span>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @php
                    $baseClass =
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-200';
                    $activeClass = 'bg-white/10 text-[#37B7C3]';
                    $inactiveClass = 'text-[#EBF4F6]/70 hover:bg-white/5 hover:text-white';
                    $iconClass = 'w-[18px] h-[18px] shrink-0';
                @endphp

                <a href="{{ auth()->user()->role == 'guru' ? route('guru.dashboard') : route('dashboard') }}"
                    class="{{ $baseClass }} {{ request()->routeIs('*.dashboard') ? $activeClass : $inactiveClass }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if (auth()->user()->role === 'guru')
                    <a href="{{ route('guru.user.index') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('guru.user.*') ? $activeClass : $inactiveClass }}">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Kelola siswa</span>
                    </a>
                    <a href="{{ route('guru.course.index') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('guru.course.*') ? $activeClass : $inactiveClass }}">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span>Kelola Materi</span>
                    </a>

                    <a href="{{ route('guru.bank_soal.index') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('guru.bank_soal.*') ? $activeClass : $inactiveClass }}">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        <span>Bank Soal</span>
                    </a>

                    @php $isRekapActive = request()->routeIs('guru.nilai.*') || request()->routeIs('guru.orientasi.*') || request()->routeIs('guru.reflection.*'); @endphp
                    <div>
                        <button type="button"
                            class="{{ $baseClass }} w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200
                            {{ $isRekapActive ? $activeClass : $inactiveClass }}"
                            data-collapse-toggle="dropdown-rekap-menu">

                            <!-- LEFT (ICON + TEXT) -->
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 {{ $iconClass }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>

                                <span class="text-sm font-medium">
                                    Rekap Nilai
                                </span>
                            </div>

                            <!-- RIGHT (ARROW) -->
                            <svg class="w-4 h-4 transition-transform duration-200
                                {{ $isRekapActive ? 'rotate-180' : '' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <ul id="dropdown-rekap-menu"
                            class="{{ $isRekapActive ? '' : 'hidden' }} mt-1 space-y-1 px-2 border-l border-[#37B7C3]/20 ml-5 py-1">
                            <li><a href="{{ route('guru.nilai.orientasi.rekap') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-[12px] font-medium {{ request()->routeIs('guru.nilai.orientasi.rekap') ? 'text-[#37B7C3] bg-[#37B7C3]/10' : 'text-[#EBF4F6]/60 hover:text-white hover:bg-white/5 transition-colors' }}">Rekap
                                    Orientasi</a></li>
                            <li><a href="{{ route('guru.nilai.rekap.lkpd') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-[12px] font-medium {{ request()->routeIs('guru.nilai.rekap.lkpd') ? 'text-[#37B7C3] bg-[#37B7C3]/10' : 'text-[#EBF4F6]/60 hover:text-white hover:bg-white/5 transition-colors' }}">Rekap
                                    LKPD</a></li>
                            <li><a href="{{ route('guru.nilai.rekap.refleksi') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-[12px] font-medium {{ request()->routeIs('guru.nilai.rekap.refleksi') ? 'text-[#37B7C3] bg-[#37B7C3]/10' : 'text-[#EBF4F6]/60 hover:text-white hover:bg-white/5 transition-colors' }}">Rekap
                                    Refleksi</a></li>
                            <li><a href="{{ route('guru.nilai.index') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-[12px] font-medium {{ request()->routeIs('guru.nilai.index') ? 'text-[#37B7C3] bg-[#37B7C3]/10' : 'text-[#EBF4F6]/60 hover:text-white hover:bg-white/5 transition-colors' }}">Rekap
                                    Postest/Pretest</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('siswa.pretest') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('siswa.pretest') ? $activeClass : $inactiveClass }}">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                        <span>Pretest</span>
                    </a>
                    <a href="{{ route('siswa.course.index') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('siswa.course.*') ? $activeClass : $inactiveClass }}">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span>Course Materi</span>
                    </a>
                    <a href="{{ route('siswa.posttest') }}"
                        class="{{ $baseClass }} {{ request()->routeIs('siswa.posttest') ? $activeClass : $inactiveClass }}">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Post Test</span>
                    </a>
                @endif
            </nav>

            <div class="p-3 m-3 rounded-xl border border-white/20 shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    {{-- Avatar diperbesar sedikit dan diberi border putih yang lebih jelas --}}
                    <img class="w-10 h-10 rounded-xl border border-white/60 object-cover shrink-0 shadow-sm"
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=088395&color=fff&bold=true"
                        alt="Avatar">
                    <div class="flex flex-col justify-center">
                        <p class="font-bold text-[14px] leading-none text-white truncate">
                            {{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-[10px] text-[#37B7C3] font-bold uppercase tracking-wider mt-1.5">
                            {{ auth()->user()->role === 'guru' ? 'Guru' : 'Siswa' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    {{-- Tombol Profile dengan background transparan putih (seperti di gambar) --}}
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center justify-center py-2 text-xs font-bold text-white bg-white/10 rounded-lg hover:bg-white/20 transition-colors duration-200">
                        Profile
                    </a>
                    {{-- Tombol Logout tanpa background bawaan, tapi jadi merah saat di-hover --}}
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center py-2 text-xs font-bold text-white bg-transparent hover:bg-red-500/80 rounded-lg transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div id="main-wrapper">
            <header
                class="sticky top-0 z-30 flex h-14 w-full items-center bg-white border-b border-slate-100 px-4 shrink-0">
                <div class="flex items-center gap-4 w-full">
                    <button id="toggleSidebar"
                        class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <nav class="flex items-center gap-2 text-[13px] overflow-hidden whitespace-nowrap">
                        <a href="#" class="text-slate-400 hover:text-slate-600 font-medium">Beranda</a>
                        @foreach (Request::segments() as $segment)
                            @if (!in_array($segment, ['siswa', 'guru', 'dashboard']))
                                <span class="text-slate-300">/</span>
                                <span
                                    class="{{ $loop->last ? 'text-slate-800 font-semibold' : 'text-slate-400 font-medium' }} truncate">{{ is_numeric($segment) ? 'Detail' : ucwords(str_replace('-', ' ', $segment)) }}</span>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-6 bg-app-bg">
                <div class="w-full mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div id="customDeleteModal" class="fixed inset-0 z-60 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0"
            id="deleteBackdrop" onclick="closeDeleteModal()"></div>
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 lg:p-8 transform scale-95 opacity-0 transition-all duration-300 z-10"
                id="deleteModalContent">
                <div
                    class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mx-auto mb-4 text-red-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Data?</h3>
                <p class="text-[13px] text-slate-500 mb-6">Data akan dihapus secara permanen dari sistem.</p>
                <div class="flex gap-2.5">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[13px] transition-colors">Batal</button>
                    <form id="executeDeleteForm" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-[13px] transition-colors shadow-lg shadow-red-600/20">Ya,
                            Hapus</button>
                    </form>
                </div>
            </div>
        </div>
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
                // Logika Desktop: Lebar/Sempit Sidebar
                html.classList.toggle('sidebar-closed');
                const state = html.classList.contains('sidebar-closed') ? 'closed' : 'open';
                localStorage.setItem('sidebar-state', state);
            }
        }

        toggleBtn.addEventListener('click', toggleSidebar);

        // Pastikan overlay hilang jika layar dibesarkan kembali ke laptop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                html.classList.remove('sidebar-open');
                overlay.classList.add('hidden');
            }
        });

        // Script Modal Hapus
        const deleteModal = document.getElementById('customDeleteModal');
        const deleteBackdrop = document.getElementById('deleteBackdrop');
        const deleteModalContent = document.getElementById('deleteModalContent');
        const executeDeleteForm = document.getElementById('executeDeleteForm');

        function openDeleteModal(actionUrl) {
            executeDeleteForm.action = actionUrl;
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteBackdrop.classList.add('opacity-100');
                deleteModalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            deleteBackdrop.classList.remove('opacity-100');
            deleteModalContent.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>
