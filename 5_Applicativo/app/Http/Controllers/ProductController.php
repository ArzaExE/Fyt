<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSizesAndQuantities;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get($id)
    {
         $product = Product::find($id);
         $images = ProductImage::where('product_id', $id)
            ->orderByDesc('is_main')
            ->get();

        $sizes = ProductSizesAndQuantities::where('product_id', $id)
            ->where('stock', '>', 0)
            ->orderBy('size', 'asc')
            ->get();

        $uniqueSizes = $sizes->unique('size');

        return view('product', compact('product', 'images', 'sizes','uniqueSizes'));
    }

}
