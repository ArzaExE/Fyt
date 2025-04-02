<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

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

        // Avvia una transazione
        DB::beginTransaction();

        try{

            $product = Product::create([
                'name' => $name,
                'color' => $color,
                'description' => $description,
                'release_date' => $release_date,
                'price' => $price,
            ]);

            // Verifica se l'immagine principale sia presente (richiesta)
            if ($request->hasFile('mainImage')) {
                $this->addMainImage($request, $product);
            } else {
                throw new \Exception('The main image is missing. Please insert at least the main one.');
            }

            // Gestione delle altre immagini (opzionali)
            if ($request->hasFile('images')) {
                // Verifica quantità immagini
                if (count($request->file('images')) <= 20) {
                    $this->addOtherImages($request, $product);
                } else {
                    throw new \Exception('Too many images have been added. Please insert a maximum of 20.');
                }
            }

            return redirect()->route('vendor', $product->id)->with('success', 'Product added successfully with images.');
            // Conferma la transazione
            DB::commit();

        }catch(\Exception $e){
            // Annulla la transazione in caso di errore
            DB::rollBack();

            return redirect()->back()->with('failed', 'Error: ' . $e->getMessage());
        }
    }

    public function addMainImage($request, $product){

        $mainImage = $request->file('mainImage');
        // Genera un nome unico per l'immagine
        $imageName = time() . '_' . $mainImage->getClientOriginalName();

        // Sposta il file direttamente nella cartella public/images
        $imagePath = $mainImage->move('productImages', $imageName);

        // Salva il percorso relativo nel database (es. images/filename.jpg)
        Image::create([
            'product_id' => $product->id,
            // Salva solo il percorso relativo
            'image' => '/' . $imageName,
            // Definisce come immagine principale
            'is_main' => 1,
        ]);

    }

    public function addOtherImages($request, $product){
        foreach ($request->file('images') as $imageFile) {
            // Genera un nome unico per l'immagine
            $imageName = time() . '_' . $imageFile->getClientOriginalName();

            // Sposta il file direttamente nella cartella public/images
            $imagePath = $imageFile->move('productImages', $imageName);

            // Salva il percorso relativo nel database (es. images/filename.jpg)
            Image::create([
                'product_id' => $product->id,
                // Salva solo il percorso relativo
                'image' => '/' . $imageName,
                // Definisce come immagine secondaria
                'is_main' => 0,
            ]);
        }
    }

}
