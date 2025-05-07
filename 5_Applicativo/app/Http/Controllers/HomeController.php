<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $images = ProductImage::where('is_main',1)
            ->orderByDesc('product_id')
            ->limit(10)
            ->get();
        return view('home', compact('images'));
    }

    public function get(){
        $product = Product::all();
        $images = ProductImage::where('is_main',1)
            ->get();

    }
}
