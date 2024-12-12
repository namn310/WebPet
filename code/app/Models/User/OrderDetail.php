<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use Illuminate\Support\Facades\DB;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['number', 'idPro', 'price', 'idOrder'];
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);
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
    public function getTotalCost()
    {
        $total = 0;
        $order = OrderDetail::all();
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
}
