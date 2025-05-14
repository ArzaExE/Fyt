<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSizesAndQuantities;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $query = Product::query()->orderByDesc('created_at');

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

//    Gestire richieste con anche filtri (reindirizzamento)
    public function handleCatalog(Request $request)
    {
        // Tutte le richieste
        if ($request->has('price') || $request->has('priceRange')) {
            return $this->filteredByPrice($request);
        }

        if($request->has('dateFilter')) {
            return $this->filteredByDate($request);
        }

        if($request->has('size')){
            return $this->filteredBySize($request);
        }


        return $this->index($request);
    }

    public function filteredByPrice(Request $request){
        $priceFilter = $request->input('price');
        $priceRangeFilter = $request->input('priceRange');
        $searchTerm = $request->query('search');
        $query = Product::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        if($priceFilter === 'lowest'){
            $query->orderBy('price','asc');
        }elseif($priceFilter === 'highest'){
            $query->orderBy('price','desc');
        }elseif ($priceRangeFilter != 0){
            $query->whereBetween('price',[0,$priceRangeFilter]);
        }elseif ($priceFilter === 0){
            $query->whereBetween('price',[0,500]);
        }

        $products = $query->paginate(12);
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

        return view('catalog',compact('products','images','searchTerm'));

    }

    public function filteredByDate(Request $request)
    {
        $dateFilter = $request->input('dateFilter');
        $searchTerm = $request->query('search');
        $query = Product::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        if ($dateFilter === 'newest') {
            $query->orderBy('release_date', 'desc');
        } elseif ($dateFilter === 'oldest') {
            $query->orderBy('release_date', 'asc');
        }

        $products = $query->paginate(12);
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

        return view('catalog', compact('products', 'images', 'searchTerm'));
    }


    //La request va passata da un validator
    public function filteredBySize(Request $request)
    {
        $sizeFilter = $request->input('size');
        $searchTerm = $request->query('search');

        $query = Product::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Filtro per taglia usando la relazione
        if ($sizeFilter) {
            $query->whereHas('sizes', function($q) use ($sizeFilter) {
                $q->where('size', $sizeFilter);
            });
        }

        $products = $query->paginate(12);
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

        return view('catalog', compact('products', 'images', 'searchTerm'));
    }
}
