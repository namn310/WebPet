<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\Voucher;
use App\Models\User\OrderDetail;
use Throwable;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['idCus', 'status', 'address', 'note', 'thanhtoan', 'idVoucher', 'created_at'];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
    public function orderDetail()
    {
        return $this->hasMany(orderDetail::class);
    }
    public function getCus($id)
    {
        $customer = DB::table('customer')->select('name')->where('id', $id)->get();
        foreach ($customer as $cus) {
            return $cus->name;
        }
    }
    public function getPhone($id)
    {
        $customer = DB::table('customer')->select('phone')->where('id', $id)->get();
        foreach ($customer as $cus) {
            return $cus->phone;
        }
    }
    public function getOrderDetail($id)
    {
        $orderDetail = OrderDetail::select()->where('idOrder', $id)->get();
        return $orderDetail;
    }
    public function getProductName($id)
    {
        $product = DB::table('products')->select("namePro")->where('idPro', $id)->get();
        foreach ($product as $row) {
            return $row->namePro;
        }
    }
    public function getImgProduct($id)
    {
        $product = DB::table('products')->select('idPro')->where('idPro', $id)->get();
        foreach ($product as $row) {
            $productImg = new product();
            return $productImg->getImgProduct($row->idPro);
        }
    }
    public function getProductDiscount($id)
    {
        $product = DB::table('products')->select('discount')->where('idPro', $id)->get();
        foreach ($product as $row) {
            return $row->discount;
        }
    }
    public function getCostWithDiscount($cost, $discount, $number)
    {
        $costTotal = $number * ($cost - ($cost *
            $discount / 100));
        return $costTotal;
    }
    public function getTotalCost($id)
    {
        $total = 0;
        $order = OrderDetail::select('number', 'price', 'idPro')->where('idOrder', $id)->get();
        foreach ($order as $row) {
            if ($row->getProductDiscount($row->idPro) > 0) {
                $total += $row->number * ($row->price - ($row->price *
                    ($row->getProductDiscount($row->idPro) / 100)));
            } else {
                $total += $row->number * $row->price;
            }
        }
        return $total;
    }
    public function getVoucher($id)
    {
        try {
            // $order = Order::find($id);
            // $idVoucher = $order->idVoucher;
            // // find voucher and get detail
            $voucher = Voucher::find($id);
            return $voucher->discount;
        } catch (Throwable $e) {
            return null;
        }
    }
    public function getTotalOrder($id)
    {
        // $orderDetail = OrderDetail::find($id);
        $order = Order::find($id);
        $totalCost = $this->getTotalCost($id);
        $voucher = $this->getVoucher($order->idVoucher);
        if ($voucher > 0 && $voucher !== null) {
            return $totalCost - ($totalCost * ($voucher / 100));
        } else {
            return $totalCost;
        }
    }
}
