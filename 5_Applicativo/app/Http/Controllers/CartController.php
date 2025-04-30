<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\ProductSizesAndQuantities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
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

    public function add(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in to add products to your cart.');
        }

        $userId = Auth::id();

        // Trova o crea il carrello
        $cart = Order::firstOrCreate(
            ['user_id' => $userId, 'status' => 'cart'],
            ['total' => 0]
        );

        $item = OrderItems::where('order_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        // Se l' Item esiste incrementa la quantità e aggiorna il prezzo in base a quest' ultima
        if ($item) {
            $item->increment('quantity');
            $item->update(['price' => $item->quantity * $product->price]);
        } else {
            OrderItems::create([
                'order_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        $cart->update(['total' => OrderItems::where('order_id', $cart->id)->sum('price')]);

        return redirect()->back()
            ->with('success', $product->name . ' successfully added to the cart!');
    }
}
