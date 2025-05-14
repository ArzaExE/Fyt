<!-- Header -->
@include('templates.header')

<!-- Token per caricamento di più immagini -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-5">
    <div class="row">
        <!-- Filters lateral bar -->
        <div class="col-md-3">
            <section id="sidebar" class="bg-light p-3 rounded shadow-sm">
                <div class="border-bottom pb-2 mb-3">
                    <h4 class="font-bold text-dark mb-0">Filters</h4>
                </div>

                <!-- Price Filter -->
                <form action="{{ route('catalog') }}" method="GET">
                    <div class="py-2 border-bottom">
                        <h6 class="font-weight-bold mb-3">Price</h6>
                        <div class="form-check mb-2">
                            <input type="radio" id="lowestPrice" name="price" value="lowest" class="form-check-input">
                            <label for="artisan" class="form-check-label">Lowest</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="radio" id="highestPrice" name="price" value="highest" class="form-check-input">
                            <label for="breakfast" class="form-check-label">Highest</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-2" for="priceRange">Price Range</label>
                            <input type="range" class="form-range w-100" id="priceRange" name="priceRange" min="0"
                                   max="500" step="5" value="0">
                            <div class="d-flex justify-content-center mt-2">
                                <span id="priceValue" class="font-weight-bold"></span>
                            </div>
                        </div>
                    </div>


                    <!-- Release date Filter -->
                    <div class="py-2 border-bottom">
                        <h6 class="font-weight-bold mb-3">Release date</h6>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="newest" class="form-check-input">
                            <label for="newest" class="form-check-label">Newest</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="oldest" class="form-check-input">
                            <label for="oldest" class="form-check-label">Oldest</label>
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div class="py-2">
                        <h6 class="font-weight-bold mb-3">Size</h6>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="size36.5" class="form-check-input">
                            <label for="size36.5" class="form-check-label">36.5</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="size37" class="form-check-input">
                            <label for="size37" class="form-check-label">37</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="size40" class="form-check-input">
                            <label for="size40" class="form-check-label">40</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="size42" class="form-check-input">
                            <label for="size42" class="form-check-label">42</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                    <button id="resetButton" type="button" class="btn btn-primary btn-sm">Reset Filters</button>
                </form>
            </section>
        </div>

        <!-- Contenuto Catalogo -->
        <div class="col-md-9">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-center mb-5 font-weight-bold text-dark">Catalog Product</h1>

            <!-- Griglia dei prodotti -->
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <!-- Carousel Immagini -->
                            <div class="p-3">
                                @if($images->count() > 0)
                                    <div id="carousel-{{ $product->id }}" class="carousel slide"
                                         data-bs-ride="carousel">
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

                    <!-- Inclusione del parziale -->
                    <div id="catalog-partial">
                        @include('profile.partials.catalog-ajax', ['products' => $products])
                    </div>

                    <!-- Navbar per paginazione -->
                    <div class="pagination d-flex justify-content-center mb-4" id="pagination-links">
                        <!-- Generatore con Laravel controlli con link per paginazione dei prodotti -->
                        {{ $products->links() }}
                    </div>

                    {{-- Gestione in caso il prodotto cercato non fosse trovato --}}
                    @if($searchTerm && $products->isEmpty())
                        <div class="flex items-center justify-center min-h-[60vh]">
                            <div class="text-center max-w-md mx-auto p-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @include('templates.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Per aggiornamento prezzo range nella filter bar --}}
    <script>
        var priceRange = document.getElementById('priceRange');
        var priceValue = document.getElementById('priceValue');

        priceRange.addEventListener('input', function () {
            priceValue.textContent = priceRange.value + " €";
        });

        // Per blocco range se radio sono attivi
        document.addEventListener("DOMContentLoaded", function () {
            const rangeInput = document.getElementById('priceRange');
            const radioButtons = document.querySelectorAll('input[name="price"]');

            function toggleRange() {
                // Se uno dei radio è selezionato → disabilita range
                const isRadioChecked = Array.from(radioButtons).some(rb => rb.checked);
                rangeInput.disabled = isRadioChecked;
            }

            // Al caricamento iniziale
            toggleRange();

            // Quando un radio cambia stato
            radioButtons.forEach(rb => {
                rb.addEventListener('change', toggleRange);
            });
        });

        function resetFilters() {
            var lowest = document.getElementById('lowestPrice');
            var highest = document.getElementById('highestPrice');
            var range = document.getElementById('priceRange');

            lowest.checked = false;
            highest.checked = false;
            range.value = 0;
        }

        var resetButton = document.getElementById('resetButton');
        resetButton.onclick = resetFilters;

    </script>
