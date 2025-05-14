@include('templates.header')
<div class="container mt-5">
    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <b><h1 style="font-size: 25px">Products</h1></b>
        </div>

        <!-- Search Bar (Product) -->
        <div class="mb-4 w-100">
            <form class="d-flex">
                <input class="form-control rounded-2 border-gray-300" id="searchProduct" type="search" placeholder="Search Product" aria-label="Search" style="background-color: #f0f0f0">
            </form>
        </div>

        <!-- Stampa esito inserimento -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <br><br>

        {{-- Carica solamente se ci sono dei prodotti --}}
    @if(!$searchTerm || !$products->isEmpty())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="w-auto">Id</th>
                    <th scope="col" class="w-auto">Name</th>
                    <th scope="col" class="w-auto">Color</th>
                    <th scope="col" class="w-auto">Description</th>
                    <th scope="col" style="width: 120px">Release Date</th>
                    <th scope="col" style="width: 90px">Price</th>
                    <th scope="col" class="w-auto">Edit</th>
                    <th scope="col" class="w-auto">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->color }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->formatted_release_date }}</td>
                        <td>{{ $product->price }} €</td>
                        <td>
                            <a href="{{route('vendor.edit', $product)}}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('vendor.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@if($searchTerm && $products->isEmpty())
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="text-center max-w-md mx-auto p-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10.5 17a6.5 6.5 0 1 1 0-13 6.5 6.5 0 0 1 0 13z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l3 3m0-3l-3 3" />
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

<!-- Stile personalizzato -->
<style>
    .btn-outline-gray-custom {
        color: #838584;
        border-color: #838584;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-gray-custom:hover {
        color: #fff;
        background-color: #838584;
        border-color: #838584;
    }

    .btn-custom-height {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var searchTimer;

        $('#searchProduct').on('keyup', function() {
            clearTimeout(searchTimer);
            var keyword = $(this).val().trim();

            searchTimer = setTimeout(function() {
                redirectToCatalog(keyword);
            }, 800);

        });

        $('#searchProduct').on('keypress', function(e) {
            if(e.which === 13) {
                e.preventDefault();
                var keyword = $(this).val().trim();
                if(keyword.length > 0) {
                    redirectToCatalog(keyword);
                }
            }
        });

        function redirectToCatalog(keyword) {
            var url = '{{ route("vendor") }}?searchProduct=' + encodeURIComponent(keyword);
            window.location.href = url;
        }
    });
</script>
