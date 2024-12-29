<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = category::paginate(10);
        return view('Admin.Quanlydanhmuc')->with('category', $category);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Adddanhmuc');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new category();
        try {
            $category->createCat($request);
        } catch (\Throwable) {
            return redirect(route('admin.categoryForm'))->with('error', 'Thêm danh mục thất bại');
        }
        return redirect(route('admin.category'))->with('notice', 'Thêm danh mục thành công !');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = category::find($id);
        $product->name = $request->input('nameCat');
        $product->update();
        return redirect(route('admin.category'))->with('notice', 'Thay đổi thành công !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = category::find($id);
        $category->delete();
        return redirect(route('admin.category'))->with('notice', 'Xóa danh mục thành công');
    }
}
