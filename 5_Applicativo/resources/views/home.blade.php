@include('templates.header')

<style>
    /* Stile comune per tutti i caroselli */
    .square-container {
        width: 100%;
        height: 100%;
        padding-bottom: 100%; /* Crea un rapporto 1:1 */
        position: relative;
        overflow: hidden;
    }

    .square-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .text-truncate {
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .carousel-item .row {
        margin-bottom: 1rem;
    }
</style>

<!-- Carosello ultime uscite -->
<div class="container mt-3">
    <h1 style="font-size: larger">Latest releases</h1><br>
    <div id="latestReleasesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(array_chunk($latest->all(), 5) as $imageChunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        @foreach($imageChunk as $image)
                            <div class="col-2 d-flex flex-column align-items-center mb-4">
                                <div class="square-container position-relative">
                                    <a href="/catalog/product/{{ $image->product_id }}" class="d-block w-100 h-100">
                                        <img
                                            src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                            class="img-fluid square-img object-fit-cover"
                                            alt="{{ $image->product->name ?? 'Product image' }}">
                                    </a>
                                </div>
                                <div class="text-center mt-2 w-100">
                                    <small class="d-block text-truncate">{{ $image->product->name ?? 'Product' }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#latestReleasesCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#latestReleasesCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Carosello articoli in evidenza -->
<div class="container mt-3">
    <h1 style="font-size: larger">Highlighted</h1><br>
    <div id="highlightedCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(array_chunk($highlight->all(), 5) as $imageChunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        @foreach($imageChunk as $image)
                            <div class="col-2 d-flex flex-column align-items-center mb-4">
                                <div class="square-container position-relative">
                                    <a href="/catalog/product/{{ $image->product_id }}" class="d-block w-100 h-100">
                                        <img
                                            src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                            class="img-fluid square-img object-fit-cover"
                                            alt="{{ $image->product->name ?? 'Product image' }}">
                                    </a>
                                </div>
                                <div class="text-center mt-2 w-100">
                                    <small class="d-block text-truncate">{{ $image->product->name}}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#highlightedCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#highlightedCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Carosello articoli più venduti -->
@if($bestSellers)
    <div class="container mt-3">
        <h1 style="font-size: larger">Best Sellers</h1><br>
        <div id="bestSellersCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach(array_chunk($bestSellers->all(), 5) as $imageChunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach($imageChunk as $image)
                                <div class="col-2 d-flex flex-column align-items-center mb-4">
                                    <div class="square-container position-relative">
                                        <a href="/catalog/product/{{ $image->product_id }}" class="d-block w-100 h-100">
                                            <img
                                                src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                                class="img-fluid square-img object-fit-cover"
                                                alt="{{ $image->product }}">
                                        </a>
                                    </div>
                                    <div class="text-center mt-2 w-100">
                                        <small class="d-block text-truncate">{{ $image->product->name }}</small>
                                        @php $tot_quantità = 0; @endphp
                                        @foreach($image->product->items as $item)
                                            @php $tot_quantità += $item->quantity @endphp
                                        @endforeach
                                        <small class="d-block text-truncate">Sold: {{ $tot_quantità }} </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#bestSellersCarousel"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bestSellersCarousel"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endif

@include('templates.footer')
