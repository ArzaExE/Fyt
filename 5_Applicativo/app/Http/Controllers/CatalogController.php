<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Recupera i 12 prodotti per la pagina richiesta
        // Il metodo paginate si occupa di eseguire una query con un limit dato come argomento
        $products = Product::paginate(12);

        // Recupera solamente l'id dei prodotti visualizzati
        // La funzione pluck di Laravel recupera il campo id dagli oggetti e li salva nell'array productId
        $idProdotti = $products->pluck('id');
        // Recupera solo l'immagine dei prodotti da visualizzare
        // "whereIn" è un metodo di Laravel che cerca nella colonna "product_id" della tabella "ProductImage" l'ID passato
        $images = ProductImage::whereIn('product_id', $idProdotti)->orderByDesc('is_main')->get();

        // Controlla se la richiesta sia stata fatta tramite ajax, altrimenti ritorna l'intera view
        if($request->ajax()){
            // Ritorno di un JSON in un parziale
            return response()->json([
                'html' => view('profile.partials.catalog-ajax', compact('products'))->render(),
            ]);
        }

        return view('catalog', compact('products', 'images'));

    }
}
