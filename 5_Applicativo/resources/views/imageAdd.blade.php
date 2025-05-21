@include('templates.header')
<h1>Prodotti</h1>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Color</th>
        <th>Description</th>
        <th>Release Date</th>
        <th>Price</th>
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
                <form action="{{ route('vendor.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="images[]" multiple>
                    <input type="number" name="id">
                    <button type="submit">Carica Immagine</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('templates.footer')
