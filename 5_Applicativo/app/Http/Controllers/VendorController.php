<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return view('templates.addProduct');
    }

    //Metodo POST per iniviare i campi del form dell' aggiunta di un nuovo prodotto
    public function upload(ProductCreateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Avvia una transazione
        DB::beginTransaction();

        try{
            $product = Product::create($request->only([
                'name', 'color', 'description', 'release_date', 'price'
            ]));

            // Verifica se l'immagine principale sia presente (richiesta)
            if ($request->hasFile('mainImage')) {
                $this->addMainImage($request, $product);
            } else {
                throw new \Exception('The main image is required.');
            }

            // Gestione delle altre immagini (opzionali)
            if ($request->hasFile('images')) {
                // Verifica quantità immagini
                if (count($request->file('images')) <= 10) {
                    $this->addOtherImages($request, $product);
                } else {
                    throw new \Exception('Maximum 10 additional images allowed');
                }
            }

            // Conferma la transazione
            DB::commit();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->route('vendor', $product->id)->with('success', 'Product created successfully');

        }catch(\Exception $e){
            // Annulla la transazione in caso di errore
            DB::rollBack();

            // Reindirizza alla pagina precedente con un codice d'uscita
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
        ProductImage::create([
            'product_id' => $product->id,
            // Salva solo il percorso relativo
            'image' => '/' . $imageName,
            // Definisce come immagine principale
            'is_main' => 1,
        ]);
    }
    public function deleteMainImage($request){

        $imageName = $request->input('old_main_image');
        $imageId = $request->input('old_main_id');

        // Elimina il file direttamente nella cartella public/images
        $filePath = public_path('productImages' . $imageName);
        unlink($filePath);

        // Elimina il percorso relativo nel database (es. images/filename.jpg)
        $image = ProductImage::find($imageId);
        $image->forceDelete();
    }

    public function addOtherImages($request, $product){
        foreach ($request->file('images') as $imageFile) {
            $imageName = time() . '_' . $imageFile->getClientOriginalName();

            // Sposta il file direttamente nella cartella public/images
            $imagePath = $imageFile->move('productImages', $imageName);

            // Salva il percorso relativo nel database (es. images/filename.jpg)
            ProductImage::create([
                'product_id' => $product->id,
                // Salva solo il percorso relativo
                'image' => '/' . $imageName,
                // Definisce come immagine principale
                'is_main' => 1,
            ]);
        }
    }

    public function deleteOtherImages($request){
        foreach ($request->file('delete_images') as $imageFile) {
            // Genera un nome unico per l'immagine
            $imageName = $imageFile->getPathname();

            // Elimina il file direttamente nella cartella public/images
            $imageFile->delete('productImages', $imageName);

            // Elimina il percorso relativo nel database (es. images/filename.jpg)
            ProductImage::destroy($imageFile->id);
        }
    }

    public function edit(Product $product){
        $main = ProductImage::where([['product_id', '=', $product->id], ['is_main', '=', 1]])->first();
        $images = ProductImage::where([['product_id', '=', $product->id], ['is_main', '=', 0]])->get();
        return view('templates.editProduct', compact('product', 'main', 'images'));
    }

    public function save(ProductCreateRequest $request, Product $product): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try{

            $product->update($request->only([
                'name', 'color', 'description', 'release_date', 'price'
            ]));


            // Verifica se l'immagine principale sia presente (richiesta)
            if ($request->hasFile('mainImage')) {
                $this->deleteMainImage($request);
                $this->addMainImage($request, $product);
            }

            // Gestione delle altre immagini (opzionali)
            if ($request->hasFile('images')) {
                // Verifica quantità immagini
                if (count($request->file('images')) <= 10) {
                    $this->deleteOtherImages($request);
                    $this->addOtherImages($request, $product);
                } else {
                    throw new \Exception('Maximum 10 additional images allowed');
                }
            }

            // Conferma la transazione
            DB::commit();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->route('vendor', $product->id)->with('success', 'Product created successfully');

        }catch(\Exception $e){
            // Annulla la transazione in caso di errore
            DB::rollBack();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->back()->with('failed', 'Error: ' . $e->getMessage());
        }
    }

}
