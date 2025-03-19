<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
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

    public function add()
    {
        $products = Product::all();
        $images = Image::all();
        foreach ($images as $image) {
            if ($image->image) {
                $image->image = 'data:image/jpeg;base64,' . base64_encode($image->image);
            }
        }
        return view('addProduct', compact('products', 'images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Controllo di validazione
        ]);

        $id = $request->get('id');
        $image = $request->file('image');
        $imageData = file_get_contents($image->getRealPath()); // Converte l'immagine in binario

        // CARICAMENTO DELLE IMMAGINI DEVE PASSARE DAL CONTROLLER IMAGE NON USER
        $product = Product::find($id); // Esempio: trova l'utente con ID 1
        $image = new Image();
        $image->image = $imageData; // Salva il binario nel campo BLOB
        $image->product_id = $product->id;
        $image->save();

        return back()->with('success', 'Immagine caricata con successo!');
    }
}
