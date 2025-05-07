<!-- Header -->
@include('templates.header')

<!-- Token per caricamento di più immagini -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Contenuto principale -->
<div class="container mt-5">
    <h1 class="text-center mb-5">Catalogo Prodotti</h1>

    <!-- Testo prodotti mostrati -->
    <div class="d-flex justify-content-left mb-4 small text-muted">
        <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</p>
    </div>

    <!-- Inclusione del parziale -->
    <div id="catalog-partial">
        @include('profile.partials.catalog-ajax', ['products' => $products])
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">No products found</h3>
            <p class="text-gray-500 mb-6">We couldn't find any results for "<span class="font-medium">{{ $searchTerm }}</span>"</p>
            <div class="space-y-3">
                <a href="{{ route('catalog') }}" class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                    Browse all products
                </a>
                <p class="text-sm text-gray-400">or try a different search term</p>
            </div>
        </div>
    </div>
@endif

<!-- Footer -->
@include('templates.footer')
