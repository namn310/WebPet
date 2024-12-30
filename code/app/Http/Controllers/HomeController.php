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
use Carbon\Carbon;

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
        //lấy dữ liệu để thống kê bán hàng theo tuần
        $order2 = Order::all();
        $listData = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
        // lấy dữ liệu bán hàng theo tháng
        $listData2 = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,

        ];
        foreach ($order2 as $row) {
            $dateOrder = $row->created_at;
            // tính toán giá trị đơn hàng
            $orderDetail2 = OrderDetail::where('idOrder', $row->id)->get();
            $total = 0;
            foreach ($orderDetail2 as $row2) {
                $total = ($row2->price * $row2->number) / 1000000;
            }
            $dayOfWeek = Carbon::parse($dateOrder)->dayName;
            $Month = Carbon::parse($dateOrder)->month;
            if (array_key_exists($dayOfWeek, $listData)) {
                $listData[$dayOfWeek] += $total; // Cộng thêm số lượng vào ngày tương ứng
            }
            if (array_key_exists($Month, $listData2)) {
                $listData2[$Month] += $total; // Cộng thêm số lượng vào ngày tương ứng
            }
        }
        // dd($listData2);
        // lấy dữ liệu ngày trong tuần truyền vào home
        $Monday = $listData['Monday'];
        $Tuesday = $listData['Tuesday'];
        $Wednesday = $listData['Wednesday'];
        $Thurday = $listData['Thursday'];
        $Friday = $listData['Friday'];
        $Saturday = $listData['Saturday'];
        $Sunday = $listData['Sunday'];
        // lấy dữ liệu tháng truyền vào home
        $jan = $listData2['1'];
        $feb = $listData2['2'];
        $mar = $listData2['3'];
        $apr = $listData2['4'];
        $may = $listData2['5'];
        $june = $listData2['6'];
        $july = $listData2['7'];
        $aug = $listData2['8'];
        $sep = $listData2['9'];
        $oc = $listData2['10'];
        $no = $listData2['11'];
        $de = $listData2['12'];
        //Thông báo
        // dd($listData2);
        $OrderNotice = Order::all();
        $CustomerNotice = Customer::all();
        return view('Admin.HomeAdmin', [
            'orderTotal' => $orderTotal,
            'productTotal' => $productTotal,
            'CustomerTotal' => $CustomerTotal,
            'productOutTotal' => $productOutTotal,
            'Cost' => $Cost,
            'orderDetail' => $orderDetail,
            'order' => $order,
            'product' => $product,
            'productImg' => $productImg,
            'OrderNotice' => $OrderNotice,
            'CustomerNotice' => $CustomerNotice,
            'product2' => $product2,
            'product4' => $product4,
            'Monday' => $Monday,
            'Tuesday' => $Tuesday,
            'Wednesday' => $Wednesday,
            'Thursday' => $Thurday,
            'Friday' => $Friday,
            'Saturday' => $Saturday,
            'Sunday' => $Sunday,
            'jan' => $jan,
            'feb' => $feb,
            'mar' => $mar,
            'apr' => $apr,
            'may' => $may,
            'june' => $june,
            'july' => $july,
            'aug' => $aug,
            'sep' => $sep,
            'oc' => $oc,
            'no' => $no,
            'de' => $de,
        ]);
    }
}
