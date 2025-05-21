<!-- Header -->
@include('templates.header')

<!-- Search bar più grande, arrotondamento immagini e categorie -->

<!-- Carosello ultime uscite -->
<div class="container mt-5">

    <h1 style="font-size: larger">Latest releases</h1><br>
    <div id="carousel1" class="carousel slide" data-bs-ride="carousel1">
        <div class="carousel-inner">
            @foreach(array_chunk($latest->all(), 5) as $imageChunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                    <div class="row justify-content-center">
                        @foreach($imageChunk as $image)
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <a class="w-100 h-100 object-fit-cover" href="/catalog/product/{{ $image->product_id }}">
                                    <img
                                        src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                        class="w-100 h-100 object-fit-cover"
                                        alt="{{ asset('img/not_found.png') }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel1"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel1"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Carosello articoli in evidenza -->
<div class="container mt-5">

    <h1 style="font-size: larger">Highlighted</h1><br>
    <div id="carousel2" class="carousel slide" data-bs-ride="carousel2">
        <div class="carousel-inner">
            @foreach(array_chunk($highlight->all(), 5) as $imageChunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                    <div class="row justify-content-center">
                        @foreach($imageChunk as $image)
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <a class="w-100 h-100 object-fit-cover" href="/catalog/product/{{ $image->product_id }}">
                                    <img
                                        src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                        class="w-100 h-100 object-fit-cover"
                                        alt="{{ asset('img/not_found.png') }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel2"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel2"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Footer -->
@include('templates.footer')
