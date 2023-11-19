<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;

class AuthClientController extends Controller
{
    //đăng nhập
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            //đăng nhập thành công
            $validate = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ],[
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Password không được để trống'
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user && $user->status == 1) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    toastr()->success('Đăng nhập thành công!');
                    return redirect()->route('index');
                }else{
                    toastr()->error('Tài khoản hoặc mật khẩu không đúng');
                    return redirect()->route('login');
                }
            } else {
                toastr()->error('Tài khoản của bạn đã bị khoá');
                return redirect()->route('login');
            }
        }
        return view('client.auth.sign-in');
    }

    //đăng ký
    public function register(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validate=$request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4|confirmed',
                'password_confirmation' => 'required',
                'phone' => 'required|numeric|digits:10',
                'name' => 'required'
            ],[
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email đã tồn tại',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Password không được để trống',
                'password.min' => 'Password phải lớn hơn 4 ký tự',
                'password.confirmed' => 'Password không khớp',
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.numeric' => 'Số điện thoại phải là dạng số',
                'phone.digits' => 'Số điện thoại phải phải là 10 số',
                'name.required' => 'Tên không được để trống',
                'password_confirmation.required' => 'Không được để trống mật khẩu nhập lại'
            ]);
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
            ]);
            $users = User::where('email', $request->email)->first();

            $name = 'Chào Mừng   ' . '  ' . $request->input('name') . '' . 'đến với boleto';
            Mail::send('admin.auth.mail', compact('name'), function ($message) use ($users) {

                $message->from('dumpfuck@gmail.com', 'Boleto');
                $message->sender('john@johndoe.com', 'John Doe');
                $message->to($users->email, $users->name);
                $message->subject('Chào Mừng đến với BoLeto');
            });
            toastr()->success('Đăng ký thành công');
            return view('client.auth.sign-up');
        }
        return view('client.auth.sign-up');
    }

    //quên mật khẩu
    public function forgotPassWord(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validate=$request->validate([
                'email' => 'required|email',
            ],[
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                toastr()->error('Email không tồn tại ! ');
                return view('client.auth.forgot-password');
            }
            $newPassword = Str::random(6);
            $user->password = bcrypt($newPassword);
            $user->save();
            $users = User::where('email', $request->email)->first();
            Mail::send('admin.auth.forgotPasswordMail', compact('newPassword'), function ($message) use ($users) {

                $message->from('dumpfuck@gmail.com', 'Boleto');
                $message->sender('john@johndoe.com', 'John Doe');
                $message->to($users->email, $users->name);
                $message->subject('Chào Mừng đến với BoLeto');
            });

            toastr()->success('Mật khẩu đã được gửi về email {{$users->email}} ');
            return view('client.auth.sign-in');
        }

        return view('client.auth.forgot-password');
    }


    //đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
