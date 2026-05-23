<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StrucLearn - Platform Pembelajaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css" rel="stylesheet" />
</head>

<body
    class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">

    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <div
                    class="bg-linear-to-r from-blue-600 to-indigo-600 text-white font-bold px-3 py-1.5 rounded-lg shadow-sm">
                    StrucLearn
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    @if (auth()->user()->role === 'siswa')
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 text-sm font-bold bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300">
                            Dashboard Siswa
                        </a>
                    @elseif(auth()->user()->role === 'guru')
                        <a href="{{ route('guru.dashboard') }}"
                            class="px-5 py-2.5 text-sm font-bold bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:shadow-indigo-600/40 hover:-translate-y-0.5 transition-all duration-300">
                            Dashboard Guru
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 text-sm font-bold bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-br from-blue-50 via-white to-slate-50 -z-10"></div>
        <div
            class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl -z-10">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-72 h-72 bg-indigo-100/30 rounded-full blur-3xl -z-10">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">

            <div class="order-2 lg:order-1">
                <div
                    class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-bold mb-6 shadow-sm">
                    Platform Pembelajaran
                </div>

                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mt-2 mb-6 leading-tight text-slate-900 tracking-tight">
                    Belajar Pemrograman <br>
                    <span class="text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-indigo-600">
                        Lebih Mudah & Terstruktur
                    </span>
                </h1>

                <p class="text-slate-600 mb-8 text-lg sm:text-xl leading-relaxed max-w-xl">
                    Tingkatkan Pemahaman <i>Pemrograman</i> Anda melalui modul interaktif, latihan kasus
                    nyata, dan praktik koding secara langsung di browser.
                </p>

                <div class="flex flex-wrap gap-4">
                    @guest
                        <a href="{{ route('register') }}"
                            class="px-8 py-3.5 text-base font-bold bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300">
                            Mulai Belajar Gratis
                        </a>
                    @endguest
                    <a href="#fitur"
                        class="px-8 py-3.5 text-base font-bold border-2 border-slate-200 bg-white text-slate-700 rounded-xl hover:bg-slate-50 hover:border-slate-300 hover:text-blue-600 transition-all duration-300">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="order-1 lg:order-2 relative flex justify-center items-center">
                <div class="absolute w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>

                <div class="relative z-10 w-full max-w-lg lg:max-w-none">
                    <div
                        class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white/50 backdrop-blur-sm transform hover:scale-[1.02] transition-transform duration-500 shadow-indigo-500/20">
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=1000"
                            alt="Programming Illustration" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>


        </div>
    </section>

    <section id="fitur" class="py-24 bg-white border-t border-slate-100 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-blue-600 font-bold tracking-wider text-sm uppercase mb-2 block">Mengapa
                    StrucLearn?</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
                    Keunggulan Platform Kami
                </h2>
                <p class="text-slate-600 text-lg">
                    Pendekatan belajar yang dirancang khusus untuk memahami konsep pemrograman secara mendalam dan
                    bermakna.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="group bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                        Materi Terstruktur
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Modul pembelajaran Python disusun secara sistematis, dilengkapi dengan LKPD dan praktik <i>Code
                            Runner</i> langsung di browser Anda.
                    </p>
                </div>

                <div
                    class="group bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        Problem-Based Learning
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Asah logika dan kemampuan <i>Computational Thinking</i> melalui pendekatan studi kasus dan
                        pemecahan masalah dunia nyata.
                    </p>
                </div>

                <div
                    class="group bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">
                        Progress Tracking
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Evaluasi diri melalui Pretest dan Posttest, serta pantau pencapaian kompetensi Anda secara
                        detail dan akurat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">

            <p class="text-slate-400 text-sm max-w-md mx-auto leading-relaxed">
                Platform Media Pembelajaran interaktif untuk mengasah Computational Thinking dan pemrograman Python.
            </p>
            <div class="w-16 h-px bg-slate-700 my-6"></div>
            <p class="text-slate-500 text-sm font-medium">
                © {{ date('Y') }} StrucLearn. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
</body>

</html>
