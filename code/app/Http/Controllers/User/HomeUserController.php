<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\Voucher;
use App\Models\User\VoucherUser;
use Illuminate\Support\Carbon;
use Throwable;

class HomeUserController extends Controller
{
    public function index()
    {
        $voucherDetail = new VoucherUser();
        $voucher = Voucher::all()->where('status', '=', 1);
        $product = product::select()->where('hot', '=', 1)->get();
        $voucherUserList = DB::table('voucher_users')->join('vouchers', 'voucher_users.id_voucher', '=', 'vouchers.id')->select('voucher_users.id', 'vouchers.time_end')->get();
        // dd($voucherUserList);
        $currentDate = now('Asia/Ho_Chi_Minh');
        // dd($currentDate);
        foreach ($voucherUserList as $row) {
            if ($row->time_end < $currentDate) {
                $voucherDetail->updateVoucherUser($row->id);
            }
        }
        // $imgProduct = $product->getImgProduct();
        return view('User.HomeView', ['product' => $product, 'voucher' => $voucher, 'voucherDetail' => $voucherDetail]);
    }
}
