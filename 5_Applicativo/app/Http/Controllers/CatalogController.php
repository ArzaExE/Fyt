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

//    Gestire richieste con anche filtri (reindirizzazionnnenennenenen)
    public function handleCatalog(Request $request){
        if ($request->has('price') || $request->has('priceRange')) {
            return $this->filteredByPrice($request);
        }

        return $this->index($request);
    }

    public function filteredByPrice(Request $request){
        $priceFilter = $request->input('price');
        $priceRangeFilter = $request->input('priceRange');
        $searchTerm = $request->query('search');
        $query = Product::query();

        if($priceFilter === 'lowest'){
            $query->orderBy('price','asc');
        }elseif($priceFilter === 'highest'){
            $query->orderBy('price','desc');
        }elseif ($priceRangeFilter){
            $query->whereBetween('price',[0,$priceRangeFilter]);
        }

        $products = $query->paginate(12);
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

        return view('catalog',compact('products','images','searchTerm'));

    }
}
