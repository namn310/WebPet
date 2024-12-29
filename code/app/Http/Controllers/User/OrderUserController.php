<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class OrderUserController extends Controller
{
    public function index()
    {
        // if(session('userGoogle')){
        //     $idCus = session('userGoogle')['user_google_id'];
        // }
        // else{
        $idCus = Auth('customer')->user()->id;
        // }
        $Order = Order::select()->where('idCus', $idCus)->get()->sortByDesc('id');
        $Count = Order::select()->where('idCus', $idCus)->get()->count();
        if ($Count) {
            $OrderCount = $Count;
        } else {
            $OrderCount = 0;
        }
        $bookingCount = Booking::select()->where('idCus', $idCus)->get()->count();
        $bookingForm = Booking::select()->where('idCus', $idCus)->get()->sortByDesc('id');
        return view('User.Order', ['Order' => $Order, 'bookingCount' => $bookingCount, 'bookingForm' => $bookingForm, 'OrderCount' => $OrderCount]);
    }
    // hủy đơn đặt hàng
    public function cancelOrder($id)
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
        return redirect(route('user.orderView'))->with('status', 'Hủy đơn hàng thành công');
    }
}
