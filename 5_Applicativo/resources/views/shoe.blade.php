<!-- Header -->
@include('templates.header')

<div class="container" style="margin-top: 100px;">
    <h1>Shoe Details</h1>
    <img id="shoe" src="{{ request()->query('img') }}" alt="Shoe Image">
    <a href="/catalog"><button>Torna al catalogo</button></a>
</div>

<!-- Footer -->
@include('templates.footer')