<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Order = Order::orderBy('id', 'desc')->paginate(10);
        return view('Admin.Quanlydonhang', ['Order' => $Order]);
    }
    public function detail($id)
    {
        $product = new Order();
        $totalPrice = $product->getTotalCost($id);
        $OrderDetail = OrderDetail::select()->where('idOrder', $id)->get();
        $Order = Order::select()->where('id', $id)->get();
        $OrderDe2 = Order::find($id);
        $discountVoucher = $product->getVoucher($OrderDe2->idVoucher);
        return view('Admin.ChiTietDonHang', ['Order' => $Order, 'OrderDetail' => $OrderDetail, 'totalPrice' => $totalPrice, 'product' => $product, 'discountVoucher' => $discountVoucher]);
    }
    public function delivery($id)
    {
        // $order = DB::table('orders')->update();
        $order = Order::find($id);
        $order->status = 1;
        $order->update();
        return redirect(route('admin.order'))->with('status', 'Giao hàng thành công');
    }
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $statusOrder = $order->status;
        // lấy thông tin chi tiết của đơn hàng
        $orderDetail = DB::table('order_detail')->select('id', 'number', 'idPro', 'idOrder')->where('idOrder', $order->id)->get();
        // nếu trạng thái đơn hàng là đã giao thì khi xóa đơn hàng không cần phải cập nhật lại số lượng của sản phẩm đó
        // nếu trạng thái đơn hàng là chưa giao thì khi xóa phải lấy số lượng sản phẩm được đặt cộng lại số lượng của sản phẩm trong kho
        if ($statusOrder === 0) {
            foreach ($orderDetail as $row) {
                $countProductInOrder = $row->number;
                //cập nhật số lượng
                $product = product::find($row->idPro);
                $product->count = $product->count + $countProductInOrder;
                $product->update();
            }
        }
        $order->delete();
        return redirect(route('admin.order'))->with('status', 'Xóa đơn hàng thành công');
    }
}
