
<h1>Prodotti</h1>

<table>
    <thead>
    <tr>
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
            <td>{{ $product->name }}</td>
            <td>{{ $product->color }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->formatted_release_date }}</td>
            <td>{{ $product->price }} €</td>
            <td>{{ $product->image }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

