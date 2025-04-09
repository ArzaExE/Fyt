<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get($id)
    {
         $product = Product::find($id);
         $images = Image::where('product_id', $id)
            ->orderByDesc('is_main')
            ->get();
         return view('product', compact('product', 'images'));
    }

}
