<!-- Header -->
@include('templates.header')

@php
    use Illuminate\Support\Facades\DB;

    $products = DB::table('products')->select('name', 'price')->get();
@endphp
<br><br><br>
<div>
    @foreach ($products as $product)
        <p>Nome: {{ $product->name }} - Prezzo: {{ $product->price }}chf</p>
    @endforeach
</div>

<!-- Prima riga
<table>
    <tr>
        <td><a href="/shoe?img={{ asset('img/s1.jpg') }}"><img id="prova" src="{{ asset('img/s1.jpg') }}" alt="Test1"></a></td>
        <td><a href="/shoe?img={{ asset('img/s2.jpg') }}"><img id="prova" src="{{ asset('img/s2.jpg') }}" alt="Test2"></a></td>
        <td><a href="/shoe?img={{ asset('img/s3.jpg') }}"><img id="prova" src="{{ asset('img/s3.jpg') }}" alt="Test3"></a></td>
        <td><a href="/shoe?img={{ asset('img/s4.jpg') }}"><img id="prova" src="{{ asset('img/s4.jpg') }}" alt="Test4"></a></td>
        <td><a href="/shoe?img={{ asset('img/s5.jpg') }}"><img id="prova" src="{{ asset('img/s5.jpg') }}" alt="Test5"></a></td>
    </tr>
</table>

<table>
    <tr>
        <td><a href="/shoe?img={{ asset('img/s1.jpg') }}"><img id="prova" src="{{ asset('img/s1.jpg') }}" alt="Test1"></a></td>
        <td><a href="/shoe?img={{ asset('img/s2.jpg') }}"><img id="prova" src="{{ asset('img/s2.jpg') }}" alt="Test2"></a></td>
        <td><a href="/shoe?img={{ asset('img/s3.jpg') }}"><img id="prova" src="{{ asset('img/s3.jpg') }}" alt="Test3"></a></td>
        <td><a href="/shoe?img={{ asset('img/s4.jpg') }}"><img id="prova" src="{{ asset('img/s4.jpg') }}" alt="Test4"></a></td>
        <td><a href="/shoe?img={{ asset('img/s5.jpg') }}"><img id="prova" src="{{ asset('img/s5.jpg') }}" alt="Test5"></a></td>
    </tr>
</table>

<table>
    <tr>
        <td><a href="/shoe?img={{ asset('img/s1.jpg') }}"><img id="prova" src="{{ asset('img/s1.jpg') }}" alt="Test1"></a></td>
        <td><a href="/shoe?img={{ asset('img/s2.jpg') }}"><img id="prova" src="{{ asset('img/s2.jpg') }}" alt="Test2"></a></td>
        <td><a href="/shoe?img={{ asset('img/s3.jpg') }}"><img id="prova" src="{{ asset('img/s3.jpg') }}" alt="Test3"></a></td>
        <td><a href="/shoe?img={{ asset('img/s4.jpg') }}"><img id="prova" src="{{ asset('img/s4.jpg') }}" alt="Test4"></a></td>
        <td><a href="/shoe?img={{ asset('img/s5.jpg') }}"><img id="prova" src="{{ asset('img/s5.jpg') }}" alt="Test5"></a></td>
    </tr>
</table>
</div>
-->

<!-- Footer -->
@include('templates.footer')
