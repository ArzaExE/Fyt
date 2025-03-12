<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class VendorController extends Controller
{
    public function index()
    {
        $products = Product::select('id','name', 'color', 'description', 'release_date', 'price')->get();

        // Passa i prodotti alla view product
        return view('vendor', compact('products'));
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
        $user = User::find($id); // Esempio: trova l'utente con ID 1
        $user->image = $imageData; // Salva il binario nel campo BLOB
        $user->save();

        return back()->with('success', 'Immagine caricata con successo!');
    }
}
