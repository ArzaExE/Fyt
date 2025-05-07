<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAddCartRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
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
            // Trova o crea il carrello
            $cart = Order::firstOrCreate(
                ['user_id' => Auth::user()->getAuthIdentifier(), 'status' => 'cart'],
                ['total' => 0]
            );
            $items = OrderItems::where('order_id', $cart->id)->get();
            return view('cart', compact('cart','items'));
        }
    }

    public function add(Product $product, ProductAddCartRequest $request)
    {
        $validatedData = $request->validated();

        if (!Auth::check() || !ProductSizesAndQuantities::where('product_id', $product->id)->where('size', $validatedData['selected_size'])->exists()) {
            return redirect()->route('catalog')->with('error', 'Something went wrong...');
        }

        $userId = Auth::user()->getAuthIdentifier();

        // Trova o crea il carrello
        $cart = Order::firstOrCreate(
            ['user_id' => $userId, 'status' => 'cart'],
            ['total' => 0]
        );

        $item = OrderItems::where('order_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('size_id', $validatedData['selected_size'])
            ->first();

        // Se l' Item esiste incrementa la quantità e aggiorna il prezzo in base a quest' ultima
        if ($item) {
            $stock = ProductSizesAndQuantities::where('product_id', $product->id)->where('size', $validatedData['selected_size'])->first();
            if ($item->quantity + 1 <= $stock->stock) {
                $item->increment('quantity');
                $item->update(['price' => $item->quantity * $product->price]);
            }
            else{
                return redirect()->back()->with('error', 'Max quantitity for this product is ' . $stock->stock);
            }
        } else {
            OrderItems::create([
                'order_id' => $cart->id,
                'size_id' => $validatedData['selected_size'],
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        $cart->update(['total' => OrderItems::where('order_id', $cart->id)->sum('price')]);

        return redirect()->back()
            ->with('success', $product->name . ' successfully added to the cart!');
    }

    public function remove(Product $product, ProductAddCartRequest $request){
        $validatedData = $request->validated();

        if (!Auth::check() || !ProductSizesAndQuantities::where('product_id', $product->id)->where('size', $validatedData['selected_size'])->exists()) {
            return redirect()->back()->with('error', 'Something went wrong...');
        }

        $userId = Auth::user()->getAuthIdentifier();

        $cart = Order::where('user_id', $userId)->where('status', 'cart')->first();

        $item = OrderItems::where('order_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('size_id', $validatedData['selected_size'])
            ->first();

        if ($item->quantity > 1) {
            $item->decrement('quantity');
            $item->update(['price' => $item->price - $product->price]);
            $cart->update(['total' => OrderItems::where('order_id', $cart->id)->sum('price')]);
        }
        else{
            $this->delete($product, $request);
        }
        return redirect()->back();
    }

    public function delete(Product $product, ProductAddCartRequest $request)
    {
        $validatedData = $request->validated();
        $userId = Auth::user()->getAuthIdentifier();
        $cart = Order::where('user_id', $userId)->where('status', 'cart')->first();

        if (!Auth::check() || !OrderItems::where('product_id', $product->id)->where('order_id', $cart->id)->exists()) {
            return redirect()->route('catalog')->with('error', 'Something went wrong...');
        }


        OrderItems::where('order_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('size_id', $validatedData['selected_size'])
            ->first()->delete();

        $cart->update(['total' => OrderItems::where('order_id', $cart->id)->sum('price')]);

        return redirect()->back();
    }
}
