@include('templates.header')
<div class="container mt-5">
    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <b><h1 style="font-size: 25px">Products</h1></b>
        </div>

        <!-- Search Bar (Product) -->
        <div class="mb-4 w-100">
            <form class="d-flex">
                <input class="form-control rounded-2" type="search" placeholder="Search Product" aria-label="Search">
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
</div>

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
