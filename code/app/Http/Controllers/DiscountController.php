<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\category;
use Throwable;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = new category();
        $discount = Discount::paginate(10);
        $discount->sortBy('id');
        return view('Admin.Discount', ['discount' => $discount, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = category::select('name', 'idCat')->get();
        return view('Admin.CreateDiscount', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $discount = new Discount();
            $discount->createDiscount($request);
        } catch (Throwable) {
            return redirect(route('admin.discount'))->with('error', 'Có lỗi xin vui lòng thử lại sau !');
        }
        return redirect(route('admin.discount'))->with('success', 'Thêm chương trình khuyến mại thành công');
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
        $cat = new category();
        $category = category::select('name', 'idCat')->get();
        $discount = Discount::find($id);
        return view('Admin.ChangeDiscount', ['discount' => $discount, 'category' => $category, 'cat' => $cat]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $discount = new Discount();
            $discount->updateDiscount($request, $id);
        } catch (Throwable) {
            return redirect(route('admin.discount'))->with('error', 'Có lỗi xin vui lòng thử lại sau !');
        }
        return redirect(route('admin.discount'))->with('success', 'Cập nhật chương trình khuyến mại thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::find($id);
        $idCat = $discount->idCat;
        DB::table('products')->where('idCat', $idCat)->update(['discount' => ' ']);
        $discount->delete();
        return redirect(route('admin.discount'))->with('notice', 'Xóa thành công !');
    }
}
