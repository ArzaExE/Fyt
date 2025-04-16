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
//        foreach ($images as $image) {
//            if ($image->image) {
//                $image->image = 'data:image/jpeg;base64,' . base64_encode($image->image);
//            }
//        }
        return view('catalog', compact('products', 'images'));
    }
}
