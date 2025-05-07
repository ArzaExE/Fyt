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

<!-- Footer -->
@include('templates.footer')
