<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $images = ProductImage::orderByDesc('is_main')->get();

        // Ottenimento numero di pagina, se non definito di default viene settato 1
        $page = $request->input('pagina', 1);

        // Recupera i 12 prodotti per la pagina richiesta
        // Il metodo paginate si occupa di eseguire una query con un limit dato come argomento
        $products = Product::paginate(12);

        // Controlla se la richiesta sia stata fatta tramite ajax
        if($request->ajax()){
            // Ritorno della risposta ajax in formato json tramite metodi di Laravel
            return response()->json([
                'products' => $products->items(),
                // Genera i link di paginazione come lista
                'links' => (string) $products->links(),
            ]);
        }

        // Ritorna la view
        return view('catalog', compact('products', 'images'));
    }
}
