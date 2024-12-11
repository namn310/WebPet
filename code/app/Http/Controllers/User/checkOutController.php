<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use Illuminate\Support\Facades\Auth;

class checkOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('User.CheckOut');
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
    public function confirmCheckOut(Request $request)
    {

        $idCus = Auth::guard('customer')->user()->id;
        $order = Order::create(['idCus' => $idCus, 'status' => 0, 'address' => $request->input('address'), 'note' => $request->input('address'), 'thanhtoan' => $request->input('payment')]);
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
        session()->forget('cart');
        return redirect(route('user.cart'))->with('status', 'Đơn hàng của bạn đã được xác nhận !');
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
        //
    }
}
