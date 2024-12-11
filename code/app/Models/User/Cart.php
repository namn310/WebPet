<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;

class Cart extends Model
{
    private $cart = [];


    use HasFactory;

    public function __construct()
    {
        $this->cart = session('cart') ? session('cart') : [];
    }
    public function listCart()
    {
        return $this->cart;
    }
    public function cartAdd($id, $count)
    {
        $product = product::find($id);
        $cart = session('cart', []);
        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        if (isset($cart[$product->idPro])) {
            // Nếu sản phẩm đã có trong giỏ, cộng thêm số lượng
            $cart[$product->idPro]['count'] += $count;
        } else {
            // Nếu sản phẩm chưa có trong giỏ, thêm sản phẩm mới vào giỏ
            $cart[$product->idPro] = [
                'idPro' => $product->idPro,
                'name' => $product->namePro,
                'cost' => $product->cost,
                'image' => $product->getImgProduct($id),
                'discount' => $product->discount,
                'count' => $count
            ];
        }

        // Lưu giỏ hàng vào session
        session(['cart' => $cart]);
    }
    public function CartTotal()
    {
        $total = 0;
        if (session('cart')) {
            foreach (session('cart') as $cart) {
                if ($cart['discount'] !== null) {
                    $total += $cart['count'] * ($cart['cost'] - ($cart['cost'] * $cart['discount']) / 100);
                } else $total += $cart['count'] * $cart['cost'];
            }
        }
        return $total;
    }
    public function countCart()
    {
        $total = 0;
        if (session('cart')) {
            foreach (session('cart') as $row) {
                $total += 1;
            }
        }
        return $total;
    }
    public function updateCart($id, $count)
    {
        $product = product::find($id);
        $cart = [
            'idPro' => $id,
            'name' => $product->namePro,
            'cost' => $product->cost,
            'image' => $product->getImgProduct($id),
            'discount' => $product->discount,
            'count' => $count
        ];
        $this->cart[$id] = $cart;
        session()->put(['cart' => $this->cart]);
    }
    public function checkOut($request, $id)
    {
        $order = new Order();
        $order->idCus = $id;
        $order->status = 0;
        $order->address = $request->input('address');
        $order->note = $request->input('note');
        $order->thanhtoan = $request->input('payment');
        $order->created_at = now('Asia/Ho_Chi_Minh');
        $totalCost = $request->input('totalCostPaymentHidden');
        //lấy idVoucher để truyền vào bảng order
        if ($request->input('idVoucher')) {
            $voucherUser = VoucherUser::find($request->input('idVoucher'));
            $voucherId = $voucherUser->id_voucher;
            $order->idVoucher = $voucherId;
        } else {
            $order->idVoucher = null;
        }
        //lưu
        $order->save();
        $latestOrder = Order::latest()->first()->toArray();
        $idLatestOrder = $latestOrder['id'];
        //  $lastPro = product::latest()->first()->toArray();
        //dd($idLatestOrder);
        foreach (session('cart') as $product) {
            $idPro = $product['idPro'];
            $orderDetail = OrderDetail::create([
                'number' => $product['count'],
                'idPro' => $idPro,
                'price' => $product['cost'],
                'idOrder' => $idLatestOrder
            ]);
        }
        // Dùng voucher xong thì giảm số lượng voucher;
        if ($request->input('idVoucher')) {
            $voucherUser = VoucherUser::find($request->input('idVoucher'));
            $soluong = $voucherUser->soluong;
            $voucherUser->soluong = $soluong - 1;
            $voucherUser->update();
        }
    }
}
