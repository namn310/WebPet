<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('Admin.QuanlyAccount', ['user' => $user]);
    }
    public function profile()
    {
        return view('Admin.users-profile');
    }
    public function logOut()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }
    public function checkLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd(Auth::user()->name);
            return redirect()->route('admin.home')->with('alert', 'Chào mừng quay trở lại');
        } else {
            return redirect()->route('admin.login')->with('status', 'Email hoặc mật khẩu không chính xác');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
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
        try {

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            $user->save();
        } catch (\Throwable) {
            return redirect('admin/register')->with('status', 'Email đã tồn tại')->with('alert', 'danger');
        };

        return redirect('admin/profile')->with('status', 'Đăng ký thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function changePass(Request $request)
    {
        $id = Auth::user()->id;
        //$customer->changePassword($id, $request);
        $user = User::find($id);
        $currentPassword = $user->password;
        $oldPassInput = $request->input('currentPass');
        if (Hash::check($oldPassInput, $currentPassword)) {

            $request->validate(
                [
                    'newPass' => [
                        'bail',
                        'regex:/^[a-zA-Z0-9!@#$%^&*]{6,}$/'
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
                $user->password = Hash::make($request->input('newPass'));
                $user->update();
            } catch (Throwable) {
                return redirect(route('admin.profile'))->with('error', 'Đổi mật khẩu không thành công');
            }
            return redirect(route('admin.profile'))->with('status', 'Đổi mật thành công');
        } else {
            return redirect(route('admin.profile'))->with('errorPass', 'Mật khẩu không chính xác');
        }
        $request->validate([]);
        dd('changepass');
    }
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        //$customer->changePassword($id, $request);
        $user = User::find($id);
        $request->validate([
            'name' => [
                'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
            ],
            'email' => [
                'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
            ]
        ], [
            'name.regex' => 'Vui lòng kiểm tra lại họ tên',
            'email.regex' => 'Vui lòng kiểm tra lại Email'
        ]);
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->update();
        } catch (Throwable) {
            return redirect(route('admin.profile'))->with('error', 'Cập nhật thông tin thất bại');
        }
        return redirect(route('admin.profile'))->with('status', 'Cập nhật thông tin thành công');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        try {
            $user->delete();
        } catch (Throwable) {
            return redirect(route('admin.manageAccount'))->with('error', 'Xóa tài khoản thất bại');
        }
        return redirect(route('admin.manageAccount'))->with('notice', 'Xóa tài khoản thành công');
    }
}
