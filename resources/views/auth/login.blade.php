<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center bg-linear-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden px-4 font-sans">

        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

        <div class="w-full max-w-md bg-white/90 backdrop-blur-xl shadow-2xl border border-white/60 rounded-4xl p-8 z-10 transition-all duration-300">

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-600 text-white mb-4 shadow-lg shadow-indigo-500/30 ring-4 ring-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Selamat Datang Kembali
                </h1>
                <p class="text-sm text-slate-500 mt-2">
                    Silakan masuk ke akun StrucLearn Anda
                </p>
            </div>

            <x-auth-session-status class="mb-5 p-3 rounded-xl bg-green-50 text-green-700 text-sm font-medium border border-green-200" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-slate-700 text-sm font-semibold mb-1.5 block" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <x-text-input id="email"
                            class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all duration-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15 outline-none"
                            type="email" name="email" :value="old('email')" required autofocus
                            placeholder="nama@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password"
                            class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm transition-all duration-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15 outline-none"
                            type="password" name="password" required placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3.5 px-4 bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-300 font-bold text-sm tracking-wide">
                        Masuk
                    </button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="mt-8 pt-5 border-t border-slate-200/60 text-center">
                    <p class="text-sm text-slate-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-bold text-blue-600 hover:text-indigo-600 hover:underline transition-colors ml-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-guest-layout>
