<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class OrderUserController extends Controller
{
    public function index()
    {
        $idCus = Auth('customer')->user()->id;
        $Order = Order::select()->where('idCus', $idCus)->get()->sortByDesc('id');
        $OrderCount = Order::select()->where('idCus', $idCus)->get()->count();
        $bookingCount = Booking::select()->where('idCus', $idCus)->get()->count();
        $bookingForm = Booking::select()->where('idCus', $idCus)->get()->sortByDesc('id');
        return view('User.Order', ['Order' => $Order, 'bookingCount' => $bookingCount, 'bookingForm' => $bookingForm,'OrderCount'=>$OrderCount]);
    }
}
