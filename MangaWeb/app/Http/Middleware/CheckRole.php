<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Xử lý request theo vai trò của người dùng
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('login');
        }

        // Kiểm tra người dùng có vai trò phù hợp không
        if (Auth::user()->role != $role) {
            // Trả về lỗi 403 hoặc chuyển hướng đến trang khác
            return abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}