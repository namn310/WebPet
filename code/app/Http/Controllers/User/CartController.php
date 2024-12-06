<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VNPAY\VNPAYController;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\User\Cart;
use App\Models\product;
use Illuminate\Support\Facades\Session;
use Throwable;
use App\Models\User\VoucherUser;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use Illuminate\Support\Facades\DB;
use Error;

class CartController extends Controller
{

    public function index(Cart $cart)
    {
        $idCus = (Auth::guard('customer')->check()) ? Auth::guard('customer')->user()->id : 0;
        $voucherDetail = new Voucher();
        $voucher = VoucherUser::select()->where('id_Cus', $idCus)->where('soluong', '>', 0)->get();
        //dd(session('cart'));
        $cartCount = $cart->countCart();
        $cartItem = $cart->listCart();
        $cartTotal = $cart->CartTotal();
        return view('User.cart', ['cartItem' => $cartItem, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount, 'voucher' => $voucher, 'voucherDetail' => $voucherDetail]);
    }
    public function add(Request $request, Cart $cart)
    {
        try {
            if (Auth::guard('customer')->check()) {
                $id = $request->input('idPro');
                $count = $request->input('count');
                // $product = product::find($id);
                //xóa session
                //session()->forget('cart');
                $cart->cartAdd($id, $count);
                return response()->json(['success' => "Thêm vào giỏ hàng thành công. Vui lòng kiểm tra giỏ hàng"]);
            } else {
                return response()->json(['error' => "Vui lòng đăng nhập !"]);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e]);
        }
    }
    public function destroyCart()
    {
        session()->forget('cart');
        return redirect(route('user.cart'))->with('status', 'Xóa giỏ hàng thành công !');
    }
    public function update(Request $request, Cart $cart)
    {
        $id = $request->input('idPro');
        $count = $request->input('count');
        foreach (session('cart') as $cartItem) {
            if ($cartItem['idPro'] == $id) {
                $cart->updateCart($id, $count);
            }
        }
        // return redirect(route('user.cart'))->with('status', 'Cập nhật thành công !');
        return response()->json(['message' => "Cập nhật thành công"]);
    }
    public function delete($id)
    {
        try {
            $cart = session('cart');
            unset($cart[$id]);
            session(['cart' => $cart]);
        } catch (Throwable) {
            return redirect(route('user.cart'))->with('error', 'Xóa sản phẩm thất bại !');
        }
        return redirect(route('user.cart'))->with('status', 'Xóa sản phẩm thành công !');
    }
    public function checkout(Cart $cart)
    {
        $cartCount = $cart->countCart();
        $cartItem = $cart->listCart();
        $cartTotal = $cart->CartTotal();
        return view('User.CheckOut', ['cartItem' => $cartItem, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount]);
    }
    public function useVoucher(Request $request)
    {
        //id voucher user
        $VoucherUser = $request->input('idVoucherUser');
        $voucher = VoucherUser::find($VoucherUser);
        // lấy idVoucher trong bảng voucher_users để lấy dữ liệu trong bảng vouchers
        $voucherDetail = Voucher::find($voucher->id_voucher);
        $voucherDetailId = $voucherDetail->id;
        // lấy giảm giá của vouchers
        $discount = $voucherDetail->discount;
        // lấy điều kiện số lượng của voucher
        $dk_soluong = $voucherDetail->dk_soluong;
        // lấy điều kiện hóa đơn của voucher
        $dk_hoadon = $voucherDetail->dk_hoadon;
        $cart = new Cart();
        $cartTotal = $cart->CartTotal();
        $cartCount = $cart->countCart();
        $costWithDiscount = $cartTotal - ($cartTotal * ($discount / 100));
        // format discount
        $discountFormat = $discount . '%';
        // format tổng tiền
        $costFormat = number_format($costWithDiscount) . 'đ';
        $cost = ['cost' => number_format($costWithDiscount), 'discount' => $discount, 'discountFormat' => $discountFormat, 'costFormat' => $costFormat, 'idVoucher' => $VoucherUser];
        //check đơn hàng xem có thỏa mãn điều kiện dùng voucher không
        $error = ['error' => 'Đơn hàng không đủ điều kiện để dùng voucher'];
        if ($cartTotal >= $dk_hoadon && $cartCount >= $dk_soluong) {
            return response()->json($cost);
        } else {
            return response()->json($error);
        }
    }
    public function confirmCheckOut(Request $request)
    {
        $cart = new Cart();
        try {
            if (session()->has('userGoogle')) {
                $idCus = session('userGoogle.user_google_id');
            } else {
                $idCus = Auth::guard('customer')->user()->id;
            }
            if ($request->input('payment') === 'Thanh toán bằng VNPAY') {
                $amount = $request->input('totalCostPaymentHidden');
                $address = $request->input('address');
                $note = $request->input('note');
                $cart->checkOut($request, $idCus);
                $vnpay = new VNPAYController();
                $vnpay->createPayment($request);
            } else {
                $cart->checkOut($request, $idCus);
                session()->forget('cart');
                return redirect(route('user.cart'))->with('status', 'Đặt hàng thành công !');
            }
        } catch (Throwable $Error) {
            // dd($Error);
            return redirect(route('user.cart'))->with('error', 'Có lỗi xin vui lòng thử lại sau !');
        }
    }
    public function saveOrderVnpay(Cart $cart)
    {
        $idCus = (Auth::guard('customer')->check()) ? Auth::guard('customer')->user()->id : 0;
        $voucherDetail = new Voucher();
        $voucher = VoucherUser::select()->where('id_Cus', $idCus)->where('soluong', '>', 0)->get();
        //dd(session('cart'));
        $cartCount = $cart->countCart();
        $cartItem = $cart->listCart();
        $cartTotal = $cart->CartTotal();
        // kiểm tra URL
        if (isset($_GET['vnp_SecureHash']) && isset($_GET['vnp_TransactionNo'])) {
            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, config('vnpay.vnp_HashSecret'));
            $status = 0;
            /*
            $status = 1 : Thanh toán thành công,
            status = 2: Thanh toán không thành công,
            status = 0: Chữ ký không hợp lệ thanh toán thất bại
            */
            // Kiểm tra kết quả giao dịch
            if ($secureHash === $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    $status = 1;
                } else {
                    $status = 2;
                }
            } else {
                $status = 0;
            }
            // tìm kiếm thông tin đơn hàng vừa lưu vào db
            // nếu status khác 1 thì thanh toán không thành công thì xóa đơn hàng vừa lưu trong db
            if ($status !== 1) {
                $orderQuery = DB::table('orders')->select('id')->orderby('id', 'desc')->limit(1)->first();
                $idLastOrder = $orderQuery->id;
                $order = Order::find($idLastOrder);
                $order->delete();
                return redirect(route('user.cart'))->with('errorPayment', 'Có lỗi trong quá trình thanh toán !');
            } else {
                session()->forget('cart');
                return redirect(route('user.cart'))->with('status', 'Đặt hàng thành công !');
            }
        } else {
            return view('User.cart', ['cartItem' => $cartItem, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount, 'voucher' => $voucher, 'voucherDetail' => $voucherDetail]);
        }
    }
}
