<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)
            ->where('role', 'admin')
            ->where('status', 'aktif')
            ->first();

        if (!$user || $user->password !== $request->password) {
            return back()->with('error', 'Username atau password admin salah.');
        }

        session([
            'admin_login' => true,
            'admin_id' => $user->user_id,
            'admin_nama' => $user->nama,
            'admin_username' => $user->username,
            'admin_role' => $user->role,
        ]);

        return redirect('/admin/dashboard');
    }
    public function dashboard()
    {
    return view('admin.dashboard');
    }
}