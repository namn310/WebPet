<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\User\Cart;
use App\Models\product;
use Illuminate\Support\Facades\Session;
use Throwable;

class CartController extends Controller
{

    public function index(Cart $cart)
    {
        //dd(session('cart'));
        $cartCount = $cart->countCart();
        $cartItem = $cart->listCart();
        $cartTotal = $cart->CartTotal();
        return view('User.cart', ['cartItem' => $cartItem, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount]);
    }
    public function add($id, Cart $cart)
    {
        $product = product::find($id);
        //xóa session
        //session()->forget('cart');
        $cart->cartAdd($id);
        return redirect(route('user.cart'));
    }
    public function destroyCart()
    {
        session()->forget('cart');
        return redirect(route('user.cart'))->with('status', 'Xóa giỏ hàng thành công !');
    }
    public function update(Request $request, Cart $cart)
    {
        foreach (session('cart') as $cartItem) {
            $id = $cartItem['idPro'];
            $count = $request->input('idPro' . $id);
            $cart->updateCart($id, $count);
        }

        return redirect(route('user.cart'))->with('status', 'Cập nhật thành công !');
    }
    public function delete($id)
    {

        try {
            $cart = session('cart');
            unset($cart[$id]);
            session(['cart' => $cart]);
        } catch (Throwable) {
            return redirect(route('user.cart'))->with('error', 'Xóa sản phẩm thất bại !');
        }
        return redirect(route('user.cart'))->with('status', 'Xóa sản phẩm thành công !');
    }
    public function checkout(Cart $cart)
    {
        $cartCount = $cart->countCart();
        $cartItem = $cart->listCart();
        $cartTotal = $cart->CartTotal();
        return view('User.CheckOut', ['cartItem' => $cartItem, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount]);
    }
}
