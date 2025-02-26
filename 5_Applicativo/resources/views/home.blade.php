<!-- Header -->
@include('templates.header')

<div class="w-100 vh-100 d-flex align-items-center justify-content-center p-3 mb-2 bg-light text-dark">
    <h1>Home Fyt</h1>
    <img src="{{ asset('img/Logo.png') }}" alt="Logo">
    <p>Oggi è il {{ date('d/m/Y') }}</p>
</div>

<!-- Footer -->
@include('templates.footer')