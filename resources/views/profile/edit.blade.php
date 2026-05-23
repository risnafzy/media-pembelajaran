@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-slate-50 font-sans antialiased text-slate-900 pb-20">

    {{-- Decorative Header Background --}}
    <div class="absolute top-0 left-0 w-full h-72 bg-linear-to-b from-[#EBF4F6] to-transparent opacity-70 -z-10"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-10">

        <div class="space-y-10">

            {{-- Update Profile Information --}}
            <section class="group">
                <div class="flex items-center gap-4 mb-6 ml-4">
                    <span class="w-10 h-0.5 bg-[#37B7C3] rounded-full"></span>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Informasi Dasar</h3>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden transition-all duration-500 group-hover:border-[#37B7C3]/30">
                    <div class="p-8 sm:p-12">
                        <div class="max-w-2xl mx-auto">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </section>

            {{-- Update Password --}}
            <section class="group">
                <div class="flex items-center gap-4 mb-6 ml-4">
                    <span class="w-10 h-0.5 bg-[#071952] rounded-full"></span>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Keamanan Akun</h3>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden transition-all duration-500 group-hover:border-[#071952]/10">
                    <div class="p-8 sm:p-12">
                        <div class="max-w-2xl mx-auto">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </section>

            {{-- Footer Note --}}
            <div class="text-center pt-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    Data Anda tersimpan secara terenkripsi
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk elemen di dalam form partials agar sinkron */
    input[type="text"], input[type="email"], input[type="password"] {
        @apply w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-3.5 text-slate-700 focus:bg-white focus:border-[#37B7C3] focus:ring-4 focus:ring-[#37B7C3]/10 transition-all outline-none mb-1;
    }

    label {
        @apply block text-sm font-bold text-[#071952] mb-2 ml-1 uppercase tracking-wider;
    }

    /* Tombol simpan di dalam partials */
    .btn-primary, button[type="submit"] {
        @apply inline-flex items-center gap-2 px-8 py-3 bg-[#37B7C3] hover:bg-[#071952] text-[#071952] hover:text-white font-black rounded-xl shadow-lg shadow-[#37B7C3]/20 transition-all active:scale-95 text-sm;
    }
</style>
@endsection
