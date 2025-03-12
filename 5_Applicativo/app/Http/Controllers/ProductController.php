<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('name', 'color', 'description', 'release_date', 'price')->get();

        // Passa i prodotti alla view product
        return view('product', compact('products'));
    }
}
