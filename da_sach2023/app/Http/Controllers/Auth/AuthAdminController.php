<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::check()) {
            toastr()->error('Lỗi! Tài khoản đang đăng nhập!');
            return redirect()->route('dashboard'); // Thay đổi '/dashboard' thành đường dẫn mà bạn muốn điều hướng người dùng đã đăng nhập đến.
        }
        if ($request->isMethod('POST')) {
            //đăng nhập thành công
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                toastr()->success('Cảm ơn! Đăng nhập thành công!');
                return redirect()->route('dashboard');
            } else {
                toastr()->error('Lỗi! Tài khoản hoặc mặt khẩu sai!');
                return redirect()->route('login.admin');
            }
        }
        return view('admin.auth.login');
    }
}
