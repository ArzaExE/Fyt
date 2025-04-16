<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSizesAndQuantities;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        $products = Product::select('id','name', 'color', 'description', 'release_date', 'price')->get();

        // Passa i prodotti alla view product
        return view('vendor', compact('products'));
    }

    public function showSales(){
        $orders = Order::with('user')->select('id', 'user_id', 'total', 'status')->get();
        return view('vendorSales',compact('orders'));
    }


    //Metodo GET per mostrare la pagina addProducts
    public function add(){
        return view('templates.addProduct');
    }

    public function edit(Product $product){
        $main = ProductImage::where([['product_id', '=', $product->id], ['is_main', '=', 1]])->first();
        $images = ProductImage::where([['product_id', '=', $product->id], ['is_main', '=', 0]])->get();
        $sizes = ProductSizesAndQuantities::where('product_id', '=', $product->id)->get();
        return view('templates.editProduct', compact('product', 'main', 'images', 'sizes'));
    }

    //Metodo POST per iniviare i campi del form dell' aggiunta di un nuovo prodotto
    public function upload(ProductCreateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Avvia una transazione
        DB::beginTransaction();

        try{
            $product = Product::create($validatedData);

            $this->addSizesAndQuantities($validatedData, $product);

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
            return redirect()->route('vendor', $product->id)->with('success', 'Product ' . $product->name .' created successfully');

        }catch(\Exception $e){
            // Annulla la transazione in caso di errore
            DB::rollBack();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->back()->with('failed', 'Error: ' . $e->getMessage());
        }
    }

    public function addSizesAndQuantities($request, $product)
    {
        $sizesAndQuantities = [];

        // Raggruppa per taglia e somma le quantità
        foreach ($request['size_quantity'] as $item) {
            $size = $item['size'];
            $quantity = $item['quantity'];

            // Controllo per taglie doppie
            if (isset($sizesAndQuantities[$size])) {
                $sizesAndQuantities[$size] += $quantity;
            } else {
                $sizesAndQuantities[$size] = $quantity;
            }
        }

        foreach($sizesAndQuantities as $size => $quantity){
            ProductSizesAndQuantities::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock' => $quantity,
            ]);
        }
    }

    public function editSizesAndQuantities($request, $product)
    {
        $sizesAndQuantities = [];

        // Raggruppa per taglia e somma le quantità
        foreach ($request['size_quantity'] as $item) {
            $size = $item['size'];
            $quantity = $item['quantity'];

            // Controllo per taglie doppie
            if (isset($sizesAndQuantities[$size])) {
                $sizesAndQuantities[$size] += $quantity;
            } else {
                $sizesAndQuantities[$size] = $quantity;
            }
        }

        ProductSizesAndQuantities::where('product_id', $product->id)->delete();

        foreach($sizesAndQuantities as $size => $quantity){
            ProductSizesAndQuantities::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock' => $quantity,
            ]);
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
                'is_main' => 0,
            ]);
        }
    }

    public function deleteOtherImages($request){
        foreach ($request->input('delete_images') as $imageId) {
            $imageName = ProductImage::where('id', $imageId)->value('image');
            $filePath = public_path('productImages' . $imageName);
            ProductImage::where('id', $imageId)->forceDelete();

            unlink($filePath);
        }
    }

    public function save(ProductEditRequest $request, Product $product): RedirectResponse
    {
//        dd($request->all());
        $validatedData = $request->validated();

        DB::beginTransaction();

        try{

            $product->update($request->only([
                'name', 'color', 'description', 'release_date', 'price'
            ]));

            $this->editSizesAndQuantities($validatedData, $product);

            $countActualImages = ProductImage::where([['product_id', '=', $product->id], ['is_main', '=', 0]])->count();

            // Verifica se l'immagine principale sia presente (richiesta)
            if ($request->hasFile('mainImage')) {
                $this->deleteMainImage($request);
                $this->addMainImage($request, $product);
            }

            if ($request->hasFile('images') && (!$request->filled('delete_images'))) {
                if (count($request->file('images')) + $countActualImages <= 10) {
                    $this->addOtherImages($request, $product);
                }
                else{
                    // Non fa vedere l'errore sulla view
                    return redirect()->back()->with('error', 'The images can be a maximum of 10');
                }
            }

            if (!$request->hasFile('images') && ($request->filled('delete_images'))) {
                $this->deleteOtherImages($request);
            }

            if ($request->hasFile('images') && ($request->filled('delete_images'))){
                $countImagesToDelete = count($request->input('delete_images'));
                if ((count($request->file('images')) + $countActualImages) -  $countImagesToDelete <= 10) {
                    $this->deleteOtherImages($request);
                    $this->addOtherImages($request, $product);
                }
                else {
                    // Non fa vedere l'errore sulla view
                    return redirect()->back()->with('error', 'The images can be a maximum of 10');
                }
            }

            // Conferma la transazione
            DB::commit();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->route('vendor', $product->id)->with('success', 'Product ' . $product->name . ' edited successfully');

        }catch(\Exception $e){
            // Annulla la transazione in caso di errore
            DB::rollBack();

            // Reindirizza alla pagina precedente con un codice d'uscita
            return redirect()->back()->with('failed', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function() use ($product) {
            $product->forceDelete();
        });

        return redirect()->route('vendor')
            ->with('success', "Product {$product->name} has been successfully deleted");
    }

}
