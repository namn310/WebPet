<?php

namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Booking;
use App\Models\User\Customer;
use App\Models\User\Order;
use App\Models\Discount;
use App\Models\Voucher;
use App\Models\User\OrderDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //update status discount
        $discount = new Discount();
        $discount->updateStatusDiscount();
        //update status voucher
        $voucher = new Voucher();
        $voucher->updateStatusVoucher();
        $CustomerTotal = Customer::all()->count();
        $productTotal = product::all()->count();
        $productOutTotal = product::select('idPro')->where('count', '<=', 0)->get()->count();
        $orderTotal = Order::where('created_at', '<', now('Asia/Ho_Chi_Minh'))->count();
        //tổng tiền
        $Cost = 0;
        $cost = OrderDetail::where('created_at', '<', now('Asia/Ho_Chi_Minh'))->select('number', 'price')->get();
        foreach ($cost as $row) {
            $Cost += $row->number * $row->price;
        }
        // đơn hàng
        $orderDetail = Order::orderBy('id', 'desc')->limit(5)->get();
        $order = new Order();
        // sản phẩm bán chạy
        $product = product::orderBy('count', 'desc')->where('hot', '=', '1')->limit(10)->get();
        $productImg = new product();
        // sản phẩm bán nhiều
        $product2 = DB::table('order_detail')
            ->join('products', 'order_detail.idPro', '=', 'products.idPro')
            ->select('order_detail.idPro', 'products.count', 'products.discount', 'products.namePro', DB::raw('SUM(order_detail.number) as Total'))
            ->groupBy('order_detail.idPro', 'products.count', 'products.namePro', 'products.discount')
            ->orderBy('Total', 'desc')
            ->limit(10)
            ->get();
        // lấy danh sách id các sản phẩm bán chạy
        $topSellingIds = $product2->pluck('idPro')->toArray();
        // sản phẩm bán chậm
        $product4 = product::select('idPro', 'namePro', 'count', 'discount')->whereNotIn('idPro', $topSellingIds)->orderBy('count', 'desc')->limit(10)->get();
        //Thông báo
        $OrderNotice = Order::all();
        $CustomerNotice = Customer::all();
        return view('Admin.HomeAdmin', ['orderTotal' => $orderTotal, 'productTotal' => $productTotal, 'CustomerTotal' => $CustomerTotal, 'productOutTotal' => $productOutTotal, 'Cost' => $Cost, 'orderDetail' => $orderDetail, 'order' => $order, 'product' => $product, 'productImg' => $productImg, 'OrderNotice' => $OrderNotice, 'CustomerNotice' => $CustomerNotice, 'product2' => $product2, 'product4' => $product4]);
    }
}
