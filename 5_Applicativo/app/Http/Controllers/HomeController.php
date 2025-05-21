<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Ultime uscite
        $latest = ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
            ->where('product_images.is_main', 1)
            ->orderByDesc('products.created_at')
            ->limit(10)
            ->get();



        // In evidenza
        $highlight = ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
            ->where('product_images.is_main', 1)
            ->orderByDesc('products.highlighted')
            ->select('product_images.*', 'products.name as product_name')
            ->limit(10)
            ->get();



        // Più venduti
        $bestSellers = ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->where('product_images.is_main', 1)
            ->select('product_images.*', 'products.name as product_name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'product_images.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return view('home', compact('latest', 'highlight', 'bestSellers'));
    }

}
