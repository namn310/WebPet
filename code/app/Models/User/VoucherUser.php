<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Voucher;

class VoucherUser extends Model
{
    use HasFactory;
    protected $table = 'voucher_users';
    protected $primaryKey = 'id';
    public $timestamp = false;
    public function Voucher()
    {
        return $this->hasMany(VoucherUser::class);
    }
    public function Customer()
    {
        return $this->hasMany(VoucherUser::class);
    }
    public function saveVoucher($id, $idCus)
    {
        $voucher = Voucher::find($id);
        $voucherUser = new VoucherUser();
        $voucherUser->soluong = 1;
        $voucherUser->status = $voucher->status;
        $voucherUser->id_voucher = $id;
        $voucherUser->id_Cus = $idCus;
        $voucherUser->save();
        // giảm số lượng voucher khi user lưu voucher
        $count = $voucher->soluong;
        $voucher->soluong = $count - 1;
        $voucher->update();
    }
    public function getIdVoucherUser($id)
    {
        $voucher = VoucherUser::select('id_voucher')->where('id_voucher', $id)->get();
        foreach ($voucher as $row) {
            return $row->id_voucher;
        }
    }
    public function updateVoucherUser($id)
    {
        $voucherUser = VoucherUser::find($id);
        $voucherUser->status = 0;
        $voucherUser->update();
    }
}
