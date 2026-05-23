<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GuruUserController extends Controller
{
    // tampil daftar user
    public function index()
    {
        $users = User::where('role', 'siswa')->get();

        return view('guru.user.index', compact('users'));
    }

    // form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('guru.user.edit', compact('user'));
    }

    // proses update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()
            ->route('guru.user.index')
            ->with('success', 'User berhasil diupdate');
    }

    // hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('guru.user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
