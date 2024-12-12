<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "users";
    public $primaryKey = "id";
    public $timestamp = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    //Check đăng nhập
    public function Login($request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd(Auth::user()->name);
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->with('status', 'Email hoặc mật khẩu không chính xác');
        }
    }

    //Tạo mới tài khoản
    public function createUser($request)
    {
        $request->validate([
            'name' => [
                'regex:/^([a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]+)((\s{1}[a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]+){1,})$/'
            ],
            'email' => [
                'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
            ],
            'password' => [
                'regex:/^[a-zA-Z0-9!@#$%^&*]{6,}$/'
            ],
            'passwordConfirm' => 'same:password'
        ], [
            'name.regex' => 'Vui lòng kiểm tra lại họ tên',
            'email.regex' => 'Vui lòng kiểm tra lại Email',
            'password.regex' => 'Mật khẩu dài tối thiểu 6 ký tự',
            'passwordConfirm.same' => 'Mật khẩu không trùng khớp'
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        $user->save();
    }
    public function changePass(){
        
    }
}
