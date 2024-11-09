<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    public $timestamp = false;
    public function voucherUser()
    {
        return $this->hasOne(Voucher::class);
    }
    public function updateStatusVoucher()
    {
        $voucher = Voucher::all();
        foreach ($voucher as $row) {
            if ($row->time_start <= now('Asia/Ho_Chi_Minh') && $row->time_end >= now('Asia/Ho_Chi_Minh')) {
                $discount2 = Voucher::find($row->id);
                $discount2->status = 1;
                $discount2->update();
            } elseif ($row->time_start <= now('Asia/Ho_Chi_Minh') && $row->time_end < now('Asia/Ho_Chi_Minh') || $row->soluong <= 0) {
                $discount2 = Voucher::find($row->id);
                $discount2->status = 0;
                $discount2->update();
            } else {
                $discount2 = Voucher::find($row->id);
                $discount2->status = 2;
                $discount2->update();
            }
        }
    }
    public function createVoucher($request)
    {
        $voucher = new Voucher();
        $voucher->ma = $request->input('ma');
        $voucher->soluong = $request->input('count');
        $voucher->dk_hoadon = $request->input('dk_hoadon');
        $voucher->dk_soluong = $request->input('dk_soluong');
        $voucher->discount = $request->input('discount');
        $voucher->description = $request->input('mota');
        $voucher->time_start = $request->input('dateStart');
        $voucher->time_end = $request->input('dateEnd');
        if ($request->input('dateStart') > now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') > now('Asia/Ho_Chi_Minh')) {
            $voucher->status = 2;
        } elseif ($request->input('dateStart') <= now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') >= now('Asia/Ho_Chi_Minh')) {
            $voucher->status = 1;
        } else $voucher->status = 0;
        $voucher->save();
    }
    public function updateVoucher($request, $id)
    {
        $voucher = Voucher::find($id);
        $voucher->ma = $request->input('ma');
        $voucher->soluong = $request->input('count');
        $voucher->dk_hoadon = $request->input('dk_hoadon');
        $voucher->dk_soluong = $request->input('dk_soluong');
        $voucher->discount = $request->input('discount');
        $voucher->description = $request->input('mota');
        $voucher->time_start = $request->input('dateStart');
        $voucher->time_end = $request->input('dateEnd');
        if ($request->input('dateStart') > now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') > now('Asia/Ho_Chi_Minh')) {
            $voucher->status = 2;
        } elseif ($request->input('dateStart') <= now('Asia/Ho_Chi_Minh') && $request->input('dateEnd') >= now('Asia/Ho_Chi_Minh')) {
            $voucher->status = 1;
        } else $voucher->status = 0;
        $voucher->update();
    }
    public function getMa($id)
    {
        $name = Voucher::find($id);
        return $name->ma;
    }
    public function getCountCon($id)
    {
        $name = Voucher::find($id);
        return $name->dk_soluong;
    }
    public function getOrderCon($id)
    {
        $name = Voucher::find($id);
        return $name->dk_hoadon;
    }
    public function getDateStart($id)
    {
        $name = Voucher::find($id);
        return $name->time_start;
    }
    public function getDateEnd($id)
    {
        $name = Voucher::find($id);
        return $name->time_end;
    }
    public function getDiscount($id)
    {
        $name = Voucher::find($id);
        return $name->discount;
    }
}
