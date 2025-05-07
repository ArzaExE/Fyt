<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $query = Product::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Paginazione DOPO aver applicato i filtri
        $products = $query->paginate(12);

        // Preload immagini solo per i prodotti paginati
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

        return view('catalog', compact('products', 'images', 'searchTerm'));
    }
}
