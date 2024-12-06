<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Customer;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AccountUserController extends Controller
{
    public function index()
    {
        return view('User.login');
    }
    public function registerForm()
    {
        return view('User.sign_in');
    }
    public function register(Request $request)
    {
        $customer = new Customer();
        $request->validate(
            [
                'name' => 'required',
                'email' => [
                    'bail',
                    'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/',
                    'unique:customer'
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
            return back()->with('statusError', 'Email đã tồn tại')->withInput();
        }
        return redirect(route('user.login'))->with('statusSuccess', 'Đăng ký thành công !');
    }
    public function inforUser()
    {
        return view('User.inforUser');
    }
    public function changePassForm()
    {
        return view('User.changepass');
    }
    public function changePass(Request $request)
    {
        $id = Auth::guard('customer')->user()->id;
        //$customer->changePassword($id, $request);
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
    public function loginCheck(Request $request)
    { {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                //dd(Auth::user()->name);
                return redirect()->route('user.home');
            } else {
                return redirect()->route('user.login')->with('status', 'Email hoặc mật khẩu không chính xác');
            }
        }
    }
    public function logOut()
    {
        // if (session()->has('userGoogle')) {
        //     session()->forget('userGoogle');
        // }
        Auth::guard('customer')->logout();
        return redirect()->route('user.home');
    }
    public function updateInfor(Request $request, $id)
    {
        $request->validate(
            [
                'name' => [
                    'bail',
                    'required',
                    'regex: /^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
                ],
                'phone' => [
                    'bail',
                    'required',
                    'regex:  /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/'
                ],
                'email' => [
                    'bail',
                    'required',
                    'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
                ]


            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.regex' => "Vui lòng nhập lại họ tên",
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.regex' => 'Vui lòng kiểm tra lại số điện thoại',
                'email.required' => 'Email không thể để trống',
                'email.regex' => 'Email không hợp lệ'
            ]
        );
        try {
            $customer = Customer::find($id);
            $customer->name = $request->input('name');
            $customer->phone = $request->input('phone');
            $customer->email = $request->input('email');

            if ($request->hasFile('avtUser')) {
                if (File::exists('assets/img-avt-customer', $customer->image)) {
                    File::delete('assets/img-avt-customer', $customer->image);
                }
                $file = $request->file('avtUser');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                // $file->move(asset('assets/img-avt-customer/' . $filename));
                $file->move('assets/img-avt-customer', $filename);
                $customer->image = $filename;
            }

            $customer->update();
        } catch (Throwable) {
            return redirect('infor')->with('notice', 'Cập nhật thông tin thất bại !');
        }
        return redirect('infor')->with('notice', 'Cập nhật thông tin thành công !');
    }
}
