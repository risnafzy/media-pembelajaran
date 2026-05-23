@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= HEADER SECTION ================= --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-800">
                        Manajemen User
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola daftar nama, email, dan hak akses pengguna sistem.
                    </p>
                </div>

                
            </div>

            {{-- ================= USER LIST SECTION ================= --}}
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-lg font-bold text-slate-800">Daftar Pengguna</h2>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-0.5 rounded-full ml-2">
                        {{ count($users) }} User
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($users as $user)
                        <div
                            class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:shadow-md hover:border-indigo-200 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            {{-- Informasi User --}}
                            <div class="flex items-start gap-4">
                                {{-- Avatar Inisial --}}
                                <span class="shrink-0 w-12 h-12 flex items-center justify-center bg-indigo-50 text-indigo-600 font-bold rounded-full border border-indigo-100 text-lg uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </span>

                                <div class="mt-0.5">
                                    <p class="text-slate-800 font-bold leading-relaxed">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-slate-500 text-sm">
                                        {{ $user->email }}
                                    </p>
                                    {{-- Badge Role --}}
                                    <div class="mt-2">
                                        <span class="bg-slate-100 border border-slate-200 text-slate-600 text-xs font-bold px-2 py-1 rounded-md">
                                            Role: {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center gap-2 sm:ml-4 shrink-0 border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('guru.user.edit', $user->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-amber-200 hover:border-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit
                                </a>

                                {{-- Tombol Hapus (Menggunakan Form Asli) --}}
                                <form action="{{ route('guru.user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin hapus user ini?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-700 hover:text-white rounded-lg transition-all duration-300 shadow-sm border border-red-200 hover:border-red-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>

                            </div>

                        </div>
                    @empty
                        {{-- Keadaan Kosong (Empty State) --}}
                        <div class="w-full flex flex-col items-center justify-center p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                            <div class="text-4xl mb-3">👥</div>
                            <p class="text-slate-500 font-medium text-center">Belum ada user yang terdaftar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
