<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Recupera tutti i prodotti
        // $products = Product::all();
        // Passa i prodotti alla view 'product'
        // return view('product', compact('products'));
    }

}
