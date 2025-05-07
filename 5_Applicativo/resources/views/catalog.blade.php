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
                        <form>
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
                                <input type="range" class="form-range w-100" id="priceRange" name="priceRange" min="0" max="500" step="5" value="0">
                                <div class="d-flex justify-content-center mt-2">
                                    <span id="priceValue" class="font-weight-bold"></span>
                                </div>
                            </div>
                        </form>
                        <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                        <button id="resetButton" type="submit" class="btn btn-primary btn-sm">De Filters</button>
                    </div>
                </form>

                <!-- Release date Filter -->
                <div class="py-2 border-bottom">
                    <h6 class="font-weight-bold mb-3">Release date</h6>
                    <form>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="newest" class="form-check-input">
                            <label for="newest" class="form-check-label">Newest</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="oldest" class="form-check-input">
                            <label for="oldest" class="form-check-label">Oldest</label>
                        </div>
                    </form>
                </div>

                <!-- Size Filter -->
                <div class="py-2">
                    <h6 class="font-weight-bold mb-3">Size</h6>
                    <form>
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
                    </form>
                </div>
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

            <!-- Testo prodotti mostrati -->
            <div class="d-flex justify-content-left mb-4 small text-muted">
                <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</p>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">We couldn't find any results for "<span class="font-medium">{{ $searchTerm }}</span>"</p>
                        <div class="space-y-3">
                            <a href="{{ route('catalog') }}" class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-gray-700 rounded-lg transition-colors">
                                Browse all products
                            </a>
                            <p class="text-sm text-gray-400">or try a different search term</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Footer -->
@include('templates.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Per aggiornamento prezzo range nella filter bar --}}
<script>
    var priceRange = document.getElementById('priceRange');
    var priceValue = document.getElementById('priceValue');

    priceRange.addEventListener('input', function() {
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
