<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Image;

class VendorController extends Controller
{
    public function index()
    {
        $products = Product::select('id','name', 'color', 'description', 'release_date', 'price')->get();

        // Passa i prodotti alla view product
        return view('vendor', compact('products'));
    }


    //Metodo GET per mostrare la pagina addProducts
    public function add(){
        return view('addProducts');
    }

    //Metodo POST per iniviare i campi del form dell' aggiunta di un nuovo prodotto
    public function upload(Request $request)
    {
        $name = $request->get('name');
        $color = $request->get('color');
        $description = $request->get('description');
        $release_date = $request->get('release_date');
        $price = $request->get('price');

        $product = Product::create([
            'name' => $name,
            'color' => $color,
            'description' => $description,
            'release_date' => $release_date,
            'price' => $price,
        ]);

        // Gestione delle immagini
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Genera un nome unico per l'immagine
                $imageName = time() . '_' . $imageFile->getClientOriginalName();

                // Sposta il file direttamente nella cartella public/images
                $imagePath = $imageFile->move('productImages', $imageName);

                // Salva il percorso relativo nel database (es. images/filename.jpg)
                Image::create([
                    'product_id' => $product->id,
                    'image' => '/' . $imageName,  // Salva solo il percorso relativo
                ]);
            }
        }

        return redirect()->route('vendor', $product->id)->with('success', 'Product added successfully with images!');
    }


    public function convertToBase64(){

    }

}
