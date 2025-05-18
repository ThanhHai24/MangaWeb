<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $categories = Category::all();
        return view('Frontend.auth.login', [
            'categories'=> $categories
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            // Check if user is an admin, if so redirect to admin dashboard
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            // For regular users, redirect to home page
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công!');
    }

    public function showRegisterForm()
    {
        $categories = Category::all();
        return view('Frontend.auth.register', [
            'categories'=> $categories
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'displayname' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    public function showForgotPasswordForm()
    {
        $categories = Category::all();
        return view('Frontend.auth.forgotpassword', [
            'categories'=> $categories
        ]);
    }
    public function showChangePasswordForm()
    {
        $categories = Category::all();
        return view('Frontend.auth.changepassword', [
            'categories'=> $categories
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->input('current-password'), $user->password)) {
            return back()->withErrors(['current-password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Update the password
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->route('profile')->with('success', 'Mật khẩu của bạn đã được thay đổi thành công!');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => 'Liên kết đặt lại mật khẩu đã được gửi đến email của bạn!'])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token)
    {
        $categories = Category::all();
        return view('Frontend.auth.reset', [
            'token' => $token, 
            'email' => $request->email,
            'categories' => $categories
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', 'Mật khẩu của bạn đã được đặt lại thành công!')
                    : back()->withErrors(['email' => [__($status)]]);
    }
}