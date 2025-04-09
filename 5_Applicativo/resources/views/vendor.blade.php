@include('templates.header')
<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between">
        <b><h1 style="font-size: 25px">Products</h1></b>

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
                        <a href="" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-trash"></i>
                        </a>
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
        color: #838584; /* Colore del testo grigio */
        border-color: #838584; /* Colore del bordo grigio */
        background-color: transparent; /* Sfondo trasparente */
        transition: all 0.3s ease; /* Transizione fluida */
    }

    .btn-outline-gray-custom:hover {
        color: #fff; /* Testo bianco al passaggio del mouse */
        background-color: #838584; /* Sfondo grigio al passaggio del mouse */
        border-color: #838584; /* Colore del bordo al passaggio del mouse */
    }

    .btn-custom-height {
        padding-top: 0.25rem; /* Riduce il padding superiore */
        padding-bottom: 0.25rem; /* Riduce il padding inferiore */
    }
</style>

