<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::all();
        return view('Admin.Quanlynhanvien', ['staff' => $staff]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Addnhanvien');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nameNV' => [
                    'bail',
                    'required',
                    'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
                ],
                'emailNV' => [
                    'bail',
                    'required',
                    'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
                ],
                'localNV' => [
                    'bail',
                    'required',
                ],
                'phoneNV' => [
                    'bail',
                    'required',
                    'regex:/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}/'

                ],
                'dateNV' => 'bail|required',
                'CMND' => [
                    'bail',
                    'required',
                    'regex:/^[0-9]{9,}$/'
                ],
                'sex' => 'required',
                'chucvu' => [
                    'bail',
                    'required',
                    'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
                ],
                'imgNV' => [
                    'required',
                    'image',

                ]
            ],
            [
                'nameNV.regex' => 'Vui lòng kiểm tra lại họ tên',
                'emailNV.regex' => 'Vui lòng kiểm tra lại email',
                'phoneNV.regex' => 'Vui lòng kiểm tra lại số điện thoại',
                'CMND.regex' => 'Vui lòng kiểm tra lại CMND',
                'chucvu.regex' => 'Vui lòng kiểm tra lại',
                'imgNV.image' => 'Vui lòng up ảnh đúng định dạng'
            ]
        );
        $staff = new Staff();
        try {
            $staff->name = $request->input('nameNV');
            $staff->email = $request->input('emailNV');
            $staff->local = $request->input('localNV');
            $staff->phone = $request->input('phoneNV');
            $staff->date = $request->input('dateNV');
            $staff->CMND = $request->input('CMND');
            $staff->sex = $request->input('sex');
            $staff->chucvu = $request->input('chucvu');
            if ($request->hasFile('imgNV')) {
                $file = $request->file('imgNV');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('assets/img-nhanvien/', $filename);
                $staff->image = $filename;
            }
            $staff->save();
        } catch (Throwable) {
            return redirect(route('admin.staffCreate'))->with('notice', 'Thêm nhân viên thất bại')->withInput(); //Nếu sai thì quay lại và không load lại form
        }
        return redirect(route('admin.staff'))->with('notice', 'Thêm nhân viên thành công');
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
        $staff = Staff::select()->where('id', $id)->get();
        return view('Admin.ChangeStaff', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nameNV' => [
                    'bail',
                    'required',
                    'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
                ],
                'emailNV' => [
                    'bail',
                    'required',
                    'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/'
                ],
                'localNV' => [
                    'bail',
                    'required',
                ],
                'phoneNV' => [
                    'bail',
                    'required',
                    'regex:/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}/'

                ],
                'dateNV' => 'bail|required',
                'CMND' => [
                    'bail',
                    'required',
                    'regex:/^[0-9]{9,}$/'
                ],
                'sex' => 'required',
                'chucvu' => [
                    'bail',
                    'required',
                    'regex:/^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/'
                ],
                'imgNV' => [

                    'image',

                ]
            ],
            [
                'nameNV.regex' => 'Vui lòng kiểm tra lại họ tên',
                'emailNV.regex' => 'Vui lòng kiểm tra lại email',
                'phoneNV.regex' => 'Vui lòng kiểm tra lại số điện thoại',
                'CMND.regex' => 'Vui lòng kiểm tra lại CMND',
                'chucvu.regex' => 'Vui lòng kiểm tra lại',
                'imgNV.image' => 'Vui lòng up ảnh đúng định dạng'
            ]
        );
        $staff = Staff::find($id);
        try {
            $staff->name = $request->input('nameNV');
            $staff->email = $request->input('emailNV');
            $staff->local = $request->input('localNV');
            $staff->phone = $request->input('phoneNV');
            $staff->date = $request->input('dateNV');
            $staff->CMND = $request->input('CMND');
            $staff->sex = $request->input('sex');
            $staff->chucvu = $request->input('chucvu');
            if ($request->hasFile('imgNV')) {
                if (File::exists('assets/img-nhanvien/' . $staff->image)) {
                    File::delete('assets/img-nhanvien/' . $staff->image);
                }
                $file = $request->file('imgNV');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('assets/img-nhanvien/', $filename);
                $staff->image = $filename;
            }
            $staff->update();
        } catch (Throwable) {
            return redirect(route('admin.staffEdit', ['id' => $staff->id]))->with('notice', 'Cập nhật thông tin nhân viên thất bại')->withInput(); //Nếu sai thì quay lại và không load lại form
        }
        return redirect(route('admin.staff'))->with('notice', 'Cập nhật thông tin nhân viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Staff::find($id);
        if (File::exists('assets/img-nhanvien/' . $staff->image)) {
            File::delete('assets/img-nhanvien/' . $staff->image);
        }
        $staff->delete();
        return redirect(route('admin.staff'))->with('notice', 'Xóa thành công');
    }
}
