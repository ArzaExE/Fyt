<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get($id)
    {
         $product = Product::find($id);
         $images = ProductImage::where('product_id', $id)
            ->orderByDesc('is_main')
            ->get();
         return view('product', compact('product', 'images'));
    }

}
