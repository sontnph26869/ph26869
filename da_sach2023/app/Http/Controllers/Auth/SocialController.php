<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;


class SocialController extends Controller
{
    // dang nhap google
    public function signInwithGoogle()
    {
        if (Auth::check()) {
            return redirect(route('index'));
        };
        return Socialite::driver('google')->redirect();
    }
    public function callbackToGoogle(Request $request)
    {
        try {
            // đăng nhập với google
            $user = Socialite::driver('google')->user();
            $finduser = User::where('gauth_id', $user->id)->first();

            // nếu đã có tài khoản tự động đăng nhập
            if ($finduser) {
                if ($finduser->status == 1) {
                    Auth::login($finduser);
                    return redirect(route('index'));
                } else {
                    toastr()->error('Đăng Nhập Thất Bại!', 'Xin Lỗi!');
                    return redirect(route('login'));
                }
                // nếu chưa có thì sẽ tự động thêm mới
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'status' => 1,
                    'password' => bcrypt('admin@123')
                ]);
                // email chào mừng
                $name =  $user->name;
                Mail::send('admin.auth.mail', compact('name'), function ($message) {
                    $user = Socialite::driver('google')->user();
                    $message->from('anhandepgiai22@gmail.com', 'Boleto');
                    $message->sender('john@johndoe.com', 'John Doe');
                    $message->to($user->email, $user->name);
                    $message->replyTo('john@johndoe.com', 'John Doe');
                    $message->subject('Chào Mừng đến với BoLeto');
                    $message->priority(3);
                });
                Auth::login($newUser);
                toastr()->success('Đăng Nhập Thành Công!', 'Thật Tuyệt!');
                return redirect(route('index'));
            }
        } catch (Exception $e) {
            toastr()->error('Đăng Nhập Thất Bại!', 'Xin Lỗi!');
            return redirect(route('login'));
        }
    }
    // dang nhap google
    public function logout()
    {
        Auth::logout();


        return redirect(route('login'));
    }
}
