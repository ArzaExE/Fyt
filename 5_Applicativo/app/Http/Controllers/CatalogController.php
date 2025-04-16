<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $images = ProductImage::orderByDesc('is_main')->get();
        return view('catalog', compact('products', 'images'));
    }
}
