<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function get(){
        $id = Auth::user()->getAuthIdentifier();
        $cart = Order::where('user_id',$id)->where('status','cart')->first();
        $id_order = $cart->id;
        $items = OrderItems::where('order_id',$id_order)->get();
        return view('cart', compact('cart','items'));
    }

    public function add($product_id){

    }
}
