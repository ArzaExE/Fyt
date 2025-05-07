<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< Updated upstream
        $searchTerm = $request->query('search');
        $query = Product::query();

        // Applica la ricerca SE esiste il parametro
        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Paginazione DOPO aver applicato i filtri
        $products = $query->paginate(12);

        // Preload immagini solo per i prodotti paginati
        $images = ProductImage::whereIn('product_id', $products->pluck('id'))
            ->orderByDesc('is_main')
            ->get();

=======
        $images = ProductImage::orderByDesc('is_main')->get();
        $page = $request->input('pagina', 1);
        $searchTerm = $request->query('search'); // Ottieni il parametro di ricerca dall'URL

        // Query base
        $query = Product::query();

        // Aggiungi condizione di ricerca se presente
        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Paginazione
        $products = $query->paginate(12);

        // Gestione AJAX (mantenuta per compatibilità)
        if($request->ajax()){
            return response()->json([
                'products' => $products->items(),
                'links' => (string) $products->links(),
                'searchTerm' => $searchTerm // Aggiungi il termine di ricerca alla risposta
            ]);
        }

>>>>>>> Stashed changes
        return view('catalog', compact('products', 'images', 'searchTerm'));
    }
}
