<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ImageProduct;

class productUser extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $primaryKey = 'idPro';

    public function getDetail($id)
    {
        $productDetail = DB::table('products')->where('idPro', $id)->get();
        return $productDetail;
    }
    public function getImgProduct($id)
    {
        $img = DB::table('image_products')->select('image')->where('idPro', $id)->limit(1)->get();
        foreach ($img as $result) {
            return $result->image;
        }
    }
    public function getAllImg($id)
    {
        $img = ImageProduct::select('image')->where('idPro', $id)->get();
        return $img;
    }
    public function getIdCat($id)
    {
        $product = DB::table('products')->select("idCat")->where('idPro', $id)->get();
        foreach ($product as $row) {
            return $row->idCat;
        }
    }
}
