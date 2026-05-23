@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="py-10">
        {{-- Menggunakan max-w-3xl agar form tidak terlalu lebar di layar besar --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= HEADER SECTION ================= --}}
            <div class="mb-8">
                <h1 class="text-2xl font-extrabold text-slate-800">
                    Edit Data Pengguna
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Perbarui informasi nama, email, dan hak akses pengguna di bawah ini.
                </p>
            </div>

            {{-- ================= FORM SECTION ================= --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <form action="{{ route('guru.user.update', $user->id) }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        {{-- Input Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ $user->name }}"
                                   required
                                   placeholder="Masukkan nama lengkap"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                        </div>

                        {{-- Input Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                                Alamat Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ $user->email }}"
                                   required
                                   placeholder="contoh@email.com"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                        </div>

                        {{-- Select Role --}}
                        <div>
                            <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">
                                Hak Akses (Role)
                            </label>
                            <div class="relative">
                                <select id="role"
                                        name="role"
                                        required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-slate-50 focus:bg-white text-slate-800 appearance-none">
                                    <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>
                                        Guru
                                    </option>
                                    <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>
                                        Siswa
                                    </option>
                                </select>
                                {{-- Panah Custom untuk Select --}}
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ================= FORM ACTIONS ================= --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">

                        {{-- Tombol Batal / Kembali (Ganti route-nya sesuai dengan nama route index Anda) --}}
                        <a href="{{ route('guru.user.index') ?? '#' }}"
                            class="inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                            Batal
                        </a>

                        {{-- Tombol Simpan --}}
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 border border-transparent rounded-xl hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
