<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\ResetPass;
use App\Models\User\Customer;
use FFI\Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('User.ForgetPass');
    }
    public function forgetPass(Request $request)
    {
        $user = DB::table('customer')->where('email', $request->input('email'))->first();
        if ($user) {
            try {
                $emailUser = $user->email;
                $token = Str::random(length: 64);
                DB::table('password_reset_tokens')->insert(['email' => $request->input('email'), 'token' => $token, 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
                Mail::send("User.ForgetNotification", ['token' => $token], function ($message) use ($emailUser) {
                    $message->to($emailUser);
                    $message->subject("Reset Password");
                });
            } catch (Exception $e) {
                return redirect(route('user.forgetPass'))->with("error", $e);
            }
            return redirect(route('user.forgetPass'))->with("success", "Vui truy kiểm tra Email và truy cập vào link để reset password");
        } else {
            return redirect(route('user.forgetPass'))->with("error", "Email chưa được đăng ký tài khoản");
        }
    }
    public function Notification($token)
    {
        return view('User.FormNewPass', ['token' => $token]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => [
                    'bail',
                    'regex:/^[a-zA-Z0-9]{6,}$/'
                ],
                'password_confirmation' => 'same:password',
            ],
            [
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.regex' => "Mật khẩu tối thiểu 6 ký tự",
                'password_confirmation.same' => 'Mật khẩu không trùng khớp'
            ]
        );
        $check = DB::table('password_reset_tokens')->where(['email' => $request->input('email'), 'token' => $request->input('token')])->first();
        if (!$check) {
            return redirect(route('user.NotiForgetPass', ['token' => $request->input('token')]))->with('status', 'Vui lòng nhập đúng Email của bạn !');
        }
        try {
            $pass = Hash::make($request->input('password'));
            Customer::where('email', $request->input('email'))->update(['password' => $pass]);
            DB::table('password_reset_tokens')->where('email', $request->input('email'))->delete();
        } catch (Throwable) {
            return redirect(route('user.NotiForgetPass', ['token' => $request->input('token')]))->with('status', 'Vui lòng nhập đúng Email của bạn !');
        }
        return redirect(route('user.login'))->with('status', 'Thay đổi mật khẩu thành công !');
    }
}
