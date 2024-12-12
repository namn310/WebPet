<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\ImageProduct;
use App\Models\User\Comment;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $primaryKey = 'idPro';
    public $timestamp = true;

    public function category()
    {
        return $this->hasMany(product::class);
    }
    public function imageProducts()
    {
        return $this->hasMany(ImageProduct::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function create($request)
    {
        $category = DB::table('categories')->select('idCat')->where('name', $request->input('danhmucAddpro'))->get();
        $product = new product();
        $product->namePro = $request->input('namepro');
        $product->description = $request->input('mota');
        $product->count = $request->input('countpro');
        $product->hot = $request->input('hotPro');
        $product->cost = $request->input('giabanpro');
        $product->discount = $request->input('discount');
        foreach ($category as $row) {
            $product->idCat = $row->idCat;
        }
        $product->save();
        if ($files = $request->file('imagepro')) {

            foreach ($files as $file) {

                $extension = $file->getClientOriginalExtension(); //lay tep mo rong cua file
                $filename =  time() . '.' . $extension;
                $file->move('assets/img-add-pro/', $filename);
                $imageProduct = ImageProduct::create([
                    'idPro' => $product->idPro,
                    'image' => $filename
                ]);

            }
        }
        return redirect(route('admin.product'))->with('notice', 'Thêm sản phẩm thành công');
    }
    public function updateProduct($request, $id)
    {
        $category = DB::table('categories')->select('idCat')->where('name', $request->input('danhmucAddpro'))->get();
        $product = product::find($id);
        $product->namePro = $request->input('namepro');
        $product->description = $request->input('mota');
        $product->count = $request->input('countpro');
        $product->hot = $request->input('hotPro');
        $product->cost = $request->input('giabanpro');
        $product->discount = $request->input('discount');
        foreach ($category as $row) {
            $product->idCat = $row->idCat;
        }
        $product->update();
        $imgProduct = ImageProduct::select()->where('idPro', $id)->get();
        //dd($imgProduct);
        $indexImg = 0;
        if ($files = $request->file('imagepro')) {
            foreach ($files as $file) {
                foreach ($imgProduct as $result) {
                    if (File::exists(asset('assets/img-add-pro/' . $result->image))) {
                        File::delete(asset('assets/img-add-pro/' . $result->image));
                    }
                    $imgId = $result->id;
                    // $imgElement = ImageProduct::find($imgId);
                    DB::table('image_products')->where('id', $imgId)->delete();
                    // dd($imgElement);
                    // $imgElement->delete();
                }
                $indexImg++;
                $extension = $file->getClientOriginalExtension(); //lay tep mo rong cua file
                $filename =  $indexImg . time() . '.' . $extension;
                $file->move('assets/img-add-pro', $filename);
             
                $imageProduct = new ImageProduct();
                $imageProduct->idPro = $product->idPro;
                $imageProduct->image = $filename;
            
                $imageProduct->save();
            }

         
        }
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
    public function getProductName($id)
    {
        $product = DB::table('products')->select("namePro")->where('idPro', $id)->get();
        foreach ($product as $row) {
            return $row->namePro;
        }
    }
    public function getCategory($id)
    {
        $category = DB::table('categories')->select('name')->where('idCat', $id)->get();
        foreach ($category as $row) {
            return $row->name;
        }
    }
   
    // src="{{ asset('assets/img-add-pro/') }}${product.idPro}"
}
