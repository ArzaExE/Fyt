<!-- Header -->
@include('templates.header')

<!-- Token per caricamento di più immagini -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Contenuto principale -->
<div class="container mt-5">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-center mb-5">Catalog Product</h1>

    <!-- Testo prodotti mostrati -->
    <div class="d-flex justify-content-left mb-4 small text-muted">
        <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</p>
    </div>

    <!-- Griglia dei prodotti -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Carousel Immagini -->
                    <div class="p-3">
                        @if($images->count() > 0)
                            <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="ratio ratio-1x1 overflow-hidden rounded-3"
                                     style="border: 1px solid #e0e0e0;">
                                    @foreach($images as $image)
                                        @if($image->product_id == $product->id)
                                            @php
                                                $isMainImage = $image->is_main;
                                            @endphp
                                            <div class="carousel-item {{ $isMainImage ? 'active' : '' }}">
                                                <img
                                                    src="{{ file_exists(public_path('productImages' . $image->image)) ? asset('productImages' . $image->image) : asset('img/not_found.png') }}"
                                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                                    alt="{{ asset('img/not_found.png') }}">
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <!-- Indicatori -->
                                <div class="carousel-indicators position-static mt-2">
                                    @php
                                        $indicatorIndex = 0;
                                    @endphp
                                    @foreach($images as $image)
                                        @if($image->product_id == $product->id)
                                            <button type="button"
                                                    data-bs-target="#carousel-{{ $product->id }}"
                                                    data-bs-slide-to="{{ $indicatorIndex }}"
                                                    class="{{ $image->is_main ? 'active' : '' }} mx-1"
                                                    style="width: 10px; height: 10px; border-radius: 50%; border: none; background-color: #D0A1FF;">
                                            </button>
                                            @php
                                                $indicatorIndex++;
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>


                                <!-- Controlli -->
                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                                          aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                                          aria-hidden="true"></span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Corpo della card -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Colore:</strong> {{ $product->color }}</li>
                            <li class="list-group-item"><strong>Data di
                                    rilascio:</strong> {{ $product->formatted_release_date }}
                            </li>
                            <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }} €</li>
                        </ul>
                    </div>

                    <!-- Footer della card -->
                    <div class="card-footer bg-transparent">
                        <a href="/catalog/product/{{ $product->id }}" class="btn w-100"
                           style="color: whitesmoke; background-color: #D0A1FF;">Dettagli</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


</div>

<!-- Navbar per paginazione -->
<div class="pagination d-flex justify-content-center mb-4" id="pagination-links">
    <!-- Generatore con Laravel controlli con link per paginazione dei prodotti -->
    {{ $products->links() }}
</div>

{{-- Gestione in caso il prodotto cercato non fosse trovato--}}
@if($searchTerm && $products->isEmpty())
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="text-center max-w-md mx-auto p-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">No products found</h3>
            <p class="text-gray-500 mb-6">We couldn't find any results for "<span
                    class="font-medium">{{ $searchTerm }}</span>"</p>
            <div class="space-y-3">
                <a href="{{ route('catalog') }}"
                   class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-gray-700 rounded-lg transition-colors">
                    Browse all products
                </a>
                <p class="text-sm text-gray-400">or try a different search term</p>
            </div>
        </div>
    </div>
@endif

<!-- Footer -->
@include('templates.footer')
