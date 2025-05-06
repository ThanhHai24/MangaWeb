<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Chuyển hướng người dùng dựa theo vai trò (role)
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->role === 'moderator') {
                return redirect()->intended('moderator/dashboard');
            } else {
                return redirect()->intended('dashboard');
            }
        }

        // Trả về lỗi nếu đăng nhập thất bại
        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->except('password'));
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}