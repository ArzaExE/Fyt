<!-- Header -->
@include('templates.header')

<!-- Contenuto principale -->
<div class="container mt-5">
    <h1 class="text-center mb-5">Catalogo Prodotti</h1>

    <!-- Griglia dei prodotti -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
<<<<<<< Updated upstream
                    <!-- Contenitore immagine con bordi -->
                    <div class="p-3"> <!-- Padding per creare spazio -->
                        <div class="ratio ratio-1x1 position-relative overflow-hidden rounded-3" style="border: 1px solid #e0e0e0;">
                            @foreach($images as $image)
                                @if($image->product_id == $product->id)
                                    <img
                                        src="{{ asset('productImages' . $image->image) }}"
                                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                        alt="{{ $product->name }}"
                                    >
                                @endif
                            @endforeach
                        </div>
=======
                    <!-- Immagine del prodotto -->
                    <div class="card-img-top text-center p-3">
                        @foreach($images as $image)
                            @if($image->product_id == $product->id)
                                <img src="{{ asset('public/productImages' . $image->image) }}">
                            @endif
                        @endforeach
>>>>>>> Stashed changes
                    </div>

                    <!-- Corpo della card -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Colore:</strong> {{ $product->color }}</li>
                            <li class="list-group-item"><strong>Data di rilascio:</strong> {{ $product->release_date }}</li>
                            <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }} €</li>
                        </ul>
                    </div>

                    <!-- Footer della card -->
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-primary w-100">Dettagli</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
@include('templates.footer')

<!-- Stile aggiuntivo -->
<style>
    .object-fit-cover {
        object-fit: cover;
        object-position: center;
    }
    /* Effetto hover per la card */
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
