<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Throwable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use app\Models\product;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $primaryKey = 'id';
    public $timestamp = false;
    public function createDiscount($request)
    {
        $discount = new Discount();
        $discount->name = $request->input('name');
        $discount->discount = $request->input('discount');
        $discount->time_start = $request->input('dateStart');
        $discount->time_end = $request->input('dateEnd');
        $discount->idCat = $request->input('category');
        if ($request->input('dateStart') > now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') > now('Asia/Ho_Chi_Minh')) {
            $discount->status = 2;
            // chưa đến time áp dụng
        } elseif ($request->input('dateStart') <= now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') >= now('Asia/Ho_Chi_Minh')) {
            $discount->status = 1;
            DB::table('products')->where('idCat', $request->input('category'))->update(['discount' => $request->input('discount')]);
            // đang áp dụng
        } else $discount->status = 0;
        // hết thời gian áp dụng
        $discount->save();
    }
    public function updateDiscount($request, $id)
    {
        $discount = Discount::find($id);
        $category = $discount->idCat;
        $discount->name = $request->input('name');
        $discount->discount = $request->input('discount');
        $discount->time_start = $request->input('dateStart');
        $discount->time_end = $request->input('dateEnd');
        $discount->idCat = $request->input('category');
        if ($request->input('dateStart') > now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') > now('Asia/Ho_Chi_Minh')) {
            $discount->status = 2;
        } elseif ($request->input('dateStart') <= now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') >= now('Asia/Ho_Chi_Minh')) {
            $discount->status = 1;
        } else $discount->status = 0;
        $discount->update();
        if ($request->input('category') != $category) {
            DB::table('products')->where('idCat', $request->input('category'))->update(['discount' => $request->input('discount')]);
            DB::table('products')->where('idCat', $category)->update(['discount' => null]);
        } else {
            DB::table('products')->where('idCat', $request->input('category'))->update(['discount' => $request->input('discount')]);
        }
    }
    public function updateStatusDiscount()
    {
        $discount = Discount::all();
        foreach ($discount as $row) {
            if ($row->time_start <= now('Asia/Ho_Chi_Minh') && $row->time_end >= now('Asia/Ho_Chi_Minh')) {
                // đang trong thời gian áp dụng
                $discount2 = Discount::find($row->id);
                $discount2->status = 1;
                DB::table('products')->where('idCat', $discount2->idCat)->update(['discount' => $discount2->discount]);
                $discount2->update();
            } elseif ($row->time_start < now('Asia/Ho_Chi_Minh') && $row->time_end < now('Asia/Ho_Chi_Minh')) {
                // hết thời gian chương trình
                $discount2 = Discount::find($row->id);
                $discount2->status = 0;
                DB::table('products')->where('idCat', $discount2->idCat)->update(['discount' => null]);
                $discount2->update();
            } else {
                // chưa đến thời gian áp dụng
                $discount2 = Discount::find($row->id);
                $discount2->status = 2;
                $discount2->update();
            }
        }
    }
    // public function updateDiscountProduct()
    // {
    //     $discount = DB::table('discounts')->select('idCat', 'discount')->where('status', 1)->get();
    //     foreach ($discount as $row) {
    //         DB::table('products')->where('idCat', $row->idCat)->update(['discount' => $row->discount]);
    //     }
    //     $discount2 = DB::table('discounts')->select('idCat', 'discount')->where('status', 0)->get();
    //     foreach ($discount2 as $row) {
    //         DB::table('products')->where('idCat', $row->idCat)->update(['discount' => null]);
    //     }
    // }
}
