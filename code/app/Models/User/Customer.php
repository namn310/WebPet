<?php

namespace App\Models\User;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Throwable;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'customer';
    public $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['email', 'name', 'phone', 'password', 'image'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
   
    public function checkLoginUser($request)
    {
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd(Auth::user()->name);
            return redirect()->route('user.home');
        } else {
            return redirect()->route('user.login')->with('status', 'Email hoặc mật khẩu không chính xác');
        }
    }
    public function createAccount($request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => [
                    'bail',
                    'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
                ],
                //nếu trong rules có regex thì phải dùng mảng
                'phone' => [
                    'bail',
                    'required',
                    'regex:/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}/'
                ],
                'password' => [
                    'bail',
                    'regex:/^[a-zA-Z0-9]{6,}$/'
                ],
                'password_confirmation' => 'same:password',


            ],
            [
                'name.required' => "Tên không được để trống",
                'email.required' => "Email không được để trống",
                'email.regex' => "Email không đúng định dạng",
                'email.unique' => "Email đã được đăng ký",
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.regex' => 'Số điện thoại không đúng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.regex' => "Mật khẩu tối thiểu 6 ký tự",
                'password_confirmation.same' => 'Mật khẩu không trùng khớp'
            ]
        );
        try {
            $customer = customer::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone')
            ]);
            $customer->save();
        } catch (Throwable) {
            return back()->with('status', 'Email đã tồn tại')->withInput();
        }
        return redirect(route('user.login'))->with('status', 'Đăng ký thành công !');
    }
    public function changePassword($id, $request)
    {
        $customer = Customer::find($id);
        $currentPassword = $customer->password;
        $oldPassInput = $request->input('currentPass');
        if (Hash::check($oldPassInput, $currentPassword)) {

            $request->validate(
                [
                    'newPass' => [
                        'bail',
                        'regex:/^[a-zA-Z0-9]{6,}$/'
                    ],
                    'confirmPass' => [
                        'bail',
                        'same:newPass'
                    ]
                ],
                [
                    'newPass.regex' => 'Mật khẩu dài tối thiểu 6 ký tự',
                    'confirmPass.same' => 'Mật khẩu không khớp'
                ]
            );
            try {
                $customer->password = Hash::make($request->input('newPass'));
                $customer->update();
            } catch (Throwable) {
                return redirect(route('user.changePassForm'))->with('error', 'Đổi mật khẩu không thành công');
            }
            return redirect(route('user.changePassForm'))->with('notice', 'Đổi mật thành công');
        } else {
            return redirect(route('user.changePassForm'))->with('errorPass', 'Mật khẩu không chính xác');
        }
    }
}
