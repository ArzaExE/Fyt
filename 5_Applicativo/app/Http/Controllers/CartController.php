<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\ProductSizesAndQuantities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        if (Auth::user() === null || Auth::user()->role->name == "admin" || Auth::user()->role->name == "vendor") {
            return redirect()->route('home');
        }
        else{
            $cart = Order::where('user_id', Auth::user()->getAuthIdentifier())->where('status', 'cart')->first();
            $items = OrderItems::where('order_id', $cart->id)->get();
            $sizes = array();
            foreach ($items as $item) {
                $sizeArray = ProductSizesAndQuantities::where('product_id', $item->product_id)->get();
                foreach ($sizeArray as $size) {
                    $sizes[number_format($size->size, 1)] = $item->product_id;
                }
            }
            return view('cart', compact('cart','items', 'sizes'));
        }
    }

    public function add($product_id){

    }
}
