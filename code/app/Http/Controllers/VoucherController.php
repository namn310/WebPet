<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use SebastianBergmann\Type\VoidType;
use Throwable;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = Voucher::orderBy('id', 'desc')->paginate(10);
        // $voucher->sortBy('id','desc');
        return view('Admin.Voucher', ['voucher' => $voucher]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  view('Admin.CreateVoucher');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $voucher = new Voucher();
        try {
            $voucher->createVoucher($request);
        } catch (Throwable) {
            return redirect(route('admin.voucher'))->with('error', 'Có lỗi vui lòng thử lại sau');
        }
        return redirect(route('admin.voucher'))->with('success', 'Tạo voucher thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher = Voucher::find($id);
        return view('Admin.ChangeVoucher', ['voucher' => $voucher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $voucher = new Voucher();
        try {
            $voucher->updateVoucher($request, $id);
        } catch (Throwable) {
            return redirect(route('admin.voucher'))->with('error', 'Có lỗi vui lòng thử lại sau');
        }
        return redirect(route('admin.voucher'))->with('success', 'Cập nhật voucher thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::find($id);
        try {
            $voucher->delete();
        } catch (Throwable) {
            return redirect(route('admin.voucher'))->with('error', 'Có lỗi vui lòng thử lại sau');
        }
        return redirect(route('admin.voucher'))->with('success', 'Xóa voucher thành công');
    }
}
