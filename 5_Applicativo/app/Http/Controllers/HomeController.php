<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

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
            ->where('products.highlighted', 1)
            ->orderByDesc('products.created_at')
            ->select('product_images.*', 'products.name as product_name')
            ->limit(10)
            ->get();



        return view('home', compact('latest', 'highlight'));
    }

}
