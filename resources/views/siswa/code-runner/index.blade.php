@extends('layouts.learning')

@section('title', 'Code Runner')
@section('page-title', 'Praktik Code Runner')

@section('content')
    <div class="min-h-screen bg-slate-50 font-sans antialiased text-slate-900 pb-10">

        {{-- Header Background Decor (Konsisten dengan modul lain) --}}
        <div class="absolute top-0 left-0 w-full h-64 bg-linear-to-b from-[#EBF4F6] to-transparent opacity-70 -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-10">

            {{-- Header Card --}}
            <div
                class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-200 shadow-xl shadow-slate-200/50 flex flex-col md:flex-row gap-8 items-center text-center md:text-left mb-8">
                <div
                    class="w-20 h-20 shrink-0 bg-[#EBF4F6] rounded-3xl flex items-center justify-center text-[#088395] shadow-inner transform -rotate-3 hover:rotate-0 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-black text-[#071952] mb-1 uppercase tracking-tight">StrucLearn Playground</h2>
                    <p class="text-slate-600 font-medium">Selesaikan tantangan pemrograman Python secara interaktif.</p>
                </div>
            </div>

            {{-- Workspace Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-[75vh] min-h-150">

                {{-- PANEL KIRI: INSTRUKSI (Gaya Kartu Putih Soft) --}}
                <div
                    class="lg:col-span-4 bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 flex flex-col overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-[#FFBD2E]"></div>
                        <h2 class="font-black text-[#071952] uppercase text-xs tracking-widest">Detail Latihan</h2>
                    </div>

                    <div class="p-8 flex-1 overflow-y-auto prose prose-slate">
                        <h3 class="text-xl font-black text-[#071952] mb-3 tracking-tight">Misi 1: Hello World</h3>
                        <p class="text-slate-600 leading-relaxed font-medium">
                            Dalam dunia pemrograman, membuat komputer menyapa "Hello World" adalah tradisi pertama bagi
                            setiap pemula.
                        </p>

                        <div class="bg-[#EBF4F6] border border-[#088395]/10 p-5 rounded-2xl mt-6">
                            <span
                                class="block text-[10px] font-black text-[#088395] uppercase tracking-widest mb-2">Instruksi:</span>
                            <p class="text-sm text-slate-700 font-bold leading-relaxed m-0 italic">
                                Perbaiki kode di editor sebelah kanan agar dapat mencetak teks <code
                                    class="text-[#088395]">Hello World</code>.
                            </p>
                        </div>

                        <div class="mt-8">
                            <span
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Expected
                                Output:</span>
                            <pre class="bg-[#071952] text-[#37B7C3] p-4 rounded-2xl font-mono text-sm border border-blue-900 shadow-inner">Hello World</pre>
                        </div>
                    </div>
                </div>

                {{-- PANEL KANAN: EDITOR & TERMINAL (Gaya Dark Pro) --}}
                <div class="lg:col-span-8 flex flex-col gap-6 h-full">

                    {{-- Editor Section --}}
                    <div
                        class="flex-1 bg-[#071952] rounded-[2.5rem] shadow-2xl border border-blue-900 overflow-hidden flex flex-col relative">
                        <div class="px-6 py-4 bg-blue-950/50 border-b border-blue-900 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-[#FF5F56]"></div>
                                    <div class="w-3 h-3 rounded-full bg-[#FFBD2E]"></div>
                                    <div class="w-3 h-3 rounded-full bg-[#27C93F]"></div>
                                </div>
                                <div class="h-4 w-px bg-blue-800 mx-2"></div>
                                <span
                                    class="text-[10px] font-mono text-slate-400 bg-[#071952] px-3 py-1 rounded-full border border-blue-800">main.py</span>
                            </div>

                            <button onclick="runPython()" id="runBtn"
                                class="group flex items-center gap-2 bg-[#37B7C3] hover:bg-[#088395] text-[#071952] px-6 py-2 rounded-xl text-sm font-black transition-all shadow-lg shadow-[#37B7C3]/20 active:scale-95 z-10">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                JALANKAN
                            </button>
                        </div>

                        <div id="editor" class="flex-1 w-full bg-[#071952]"></div>
                    </div>

                    {{-- Terminal Section --}}
                    <div
                        class="h-48 bg-[#0D1117] rounded-4xl shadow-2xl border border-slate-800 overflow-hidden flex flex-col">
                        <div class="px-6 py-3 border-b border-slate-800 bg-[#161B22] flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Console
                                Output</span>
                            <div class="flex items-center gap-2">
                                <div id="status-dot" class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                                <span id="pyodide-status"
                                    class="text-[10px] font-bold text-amber-500 uppercase tracking-wider">Menyiapkan
                                    Python...</span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 overflow-y-auto font-mono text-sm">
                            <pre id="output" class="text-slate-500 italic whitespace-pre-wrap">Menunggu instruksi...</pre>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Monaco & Pyodide Scripts (Tetap seperti aslinya, hanya penyesuaian font) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>
    <script>
        require.config({
            paths: {
                vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs'
            }
        });
        let editor;
        require(["vs/editor/editor.main"], function() {
            editor = monaco.editor.create(document.getElementById('editor'), {
                value: `# Ketik kodemu di bawah ini`,
                language: "python",
                theme: "vs-dark",
                fontSize: 16,
                fontFamily: "'JetBrains Mono', 'Fira Code', monospace",
                minimap: {
                    enabled: false
                },
                automaticLayout: true,
                padding: {
                    top: 20
                },
                scrollBeyondLastLine: false,
                roundedSelection: true,
                backgroundColor: '#071952'
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/pyodide/v0.26.2/full/pyodide.js"></script>
    <script>
        let pyodide;
        let isPyodideReady = false;
        const statusEl = document.getElementById("pyodide-status");
        const dotEl = document.getElementById("status-dot");
        const btnRun = document.getElementById("runBtn");

        async function initPyodide() {
            try {
                btnRun.disabled = true;
                pyodide = await loadPyodide();
                isPyodideReady = true;
                statusEl.textContent = "Python Ready ✅";
                statusEl.classList.replace("text-amber-500", "text-[#37B7C3]");
                dotEl.classList.replace("bg-amber-500", "bg-[#37B7C3]");
                dotEl.classList.remove("animate-pulse");
                btnRun.disabled = false;
            } catch (err) {
                statusEl.textContent = "Gagal memuat Python ❌";
                statusEl.classList.replace("text-amber-500", "text-red-500");
            }
        }
        initPyodide();

        async function runPython() {
            if (!isPyodideReady) return;
            let code = editor.getValue();
            let outputEl = document.getElementById("output");
            outputEl.innerHTML = '<span class="text-[#37B7C3] animate-pulse">Running script...</span>';
            try {
                await pyodide.runPythonAsync(`
import sys
from io import StringIO
sys.stdout = StringIO()
            `);
                await pyodide.runPythonAsync(code);
                let result = await pyodide.runPythonAsync("sys.stdout.getvalue()");
                outputEl.className = "text-[#37B7C3] whitespace-pre-wrap";
                outputEl.textContent = result || "Script dijalankan tanpa output.";
            } catch (error) {
                outputEl.className = "text-red-400 whitespace-pre-wrap";
                outputEl.textContent = error;
            }
        }
    </script>
@endsection
