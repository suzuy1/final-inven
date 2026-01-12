<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // DAFTAR USER
    public function index()
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengelola pengguna.');
        }

        $users = User::latest()->get();
        return view('pages.users.index', compact('users'));
    }

    // FORM TAMBAH
    public function create()
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat menambah pengguna.');
        }

        return view('pages.users.create');
    }

    // SIMPAN USER BARU
    public function store(Request $request)
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat menambah pengguna.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,user'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit(User $user)
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengedit pengguna.');
        }

        return view('pages.users.edit', compact('user'));
    }

    // UPDATE USER
    public function update(Request $request, User $user)
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengubah data pengguna.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data pengguna diperbarui.');
    }

    // HAPUS USER
    public function destroy(User $user)
    {
        // Double-check: Hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat menghapus pengguna.');
        }

        // Jangan biarkan admin menghapus dirinya sendiri
        if ($user->id == Auth::id()) {
            return back()->withErrors(['msg' => 'Anda tidak bisa menghapus akun sendiri!']);
        }

        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }
}