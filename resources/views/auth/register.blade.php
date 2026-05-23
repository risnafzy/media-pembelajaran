<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-50 via-white to-slate-50 relative overflow-hidden py-10 px-4">

        <div
            class="absolute top-0 left-0 -translate-y-12 -translate-x-1/3 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl -z-10">
        </div>
        <div
            class="absolute bottom-0 right-0 translate-y-1/3 translate-x-1/3 w-72 h-72 bg-indigo-100/50 rounded-full blur-3xl -z-10">
        </div>

        <div
            class="w-full max-w-md bg-white/80 backdrop-blur-sm shadow-2xl border border-white rounded-3xl p-8 sm:p-10 z-10">

            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-600 text-white mb-5 shadow-lg shadow-blue-600/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Buat Akun Baru
                </h1>
                <p class="text-sm text-slate-500 mt-2 font-medium">
                    Bergabunglah untuk memulai perjalanan belajar Anda
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-1.5 ml-1" />
                    <x-text-input id="name"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        placeholder="Nama.." />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500 ml-1" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-semibold mb-1.5 ml-1" />
                    <x-text-input id="email"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
                        type="email" name="email" :value="old('email')" required autocomplete="username"
                        placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500 ml-1" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold mb-1.5 ml-1" />
                    <x-text-input id="password"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
                        type="password" name="password" required autocomplete="new-password"
                        placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500 ml-1" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                        class="text-slate-700 font-semibold mb-1.5 ml-1" />
                    <x-text-input id="password_confirmation"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 outline-none"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500 ml-1" />
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        class="font-semibold text-blue-600 hover:text-blue-700 hover:underline transition-colors">
                        Login
                    </a>
                </p>
            </div>

        </div>
    </div>

</x-guest-layout>
