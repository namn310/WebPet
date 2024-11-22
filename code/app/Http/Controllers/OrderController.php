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
        $Order = Order::all();
        return view('Admin.Quanlydonhang', ['Order' => $Order]);
    }
    public function detail($id)
    {
        $product = new Order();
        $totalPrice = $product->getTotalCost($id);
        $OrderDetail = OrderDetail::select()->where('idOrder', $id)->get();
        $Order = Order::select()->where('id', $id)->get();
        // $Order = Order::find($id)->get();
        return view('Admin.ChiTietDonHang', ['Order' => $Order, 'OrderDetail' => $OrderDetail, 'totalPrice' => $totalPrice]);
    }
    public function delivery($id)
    {
        // $order = DB::table('orders')->update();
        $order = Order::find($id);
        $order->status = 1;
        $product = OrderDetail::select('number', 'idPro')->where('idOrder', $id)->get();
        foreach ($product as $row) {
            $productDetail = product::select('count', 'idPro')->where('idPro', $row->idPro)->get();
            foreach ($productDetail as $pro) {
                $updatePro = product::find($pro->idPro);
                $updatePro->count = $pro->count - $row->number;
                // dd($pro->count - $row->number);
                $updatePro->update();
            }
        }
        $order->update();
        return redirect(route('admin.order'))->with('status', 'Giao hàng thành công');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect(route('admin.order'))->with('status', 'Xóa đơn hàng thành công');
    }
}
