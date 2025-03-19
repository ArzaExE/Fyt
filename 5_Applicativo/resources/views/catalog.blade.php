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
                    <!-- Immagine del prodotto -->
                    <div class="card-img-top text-center p-3">
                        @foreach($images as $image)
                            @if($image->product_id == $product->id)
                                <img src="{{ $image->image }}" alt="Immagine Prodotto" class="img-fluid" style="max-height: 200px;">
                            @endif
                        @endforeach
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

                    <!-- Footer della card (es. pulsante per dettagli) -->
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-primary btn-block">Dettagli</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
@include('templates.footer')
