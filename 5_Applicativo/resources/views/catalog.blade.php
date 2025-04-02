<!-- Header -->
@include('templates.header')

<!-- Contenuto principale -->
<div class="container mt-5" >
    <h1 class="text-center mb-5">Catalogo Prodotti</h1>
    <!-- Griglia dei prodotti -->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Carousel Immagini -->
                    <div class="p-3">
                        @if($images->count() > 0)
                            <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="ratio ratio-1x1 overflow-hidden rounded-3" style="border: 1px solid #e0e0e0;">
                                    @php
                                        $isMainImage = true;
                                    @endphp

                                    @foreach($images as $image)
                                        @if($image->product_id == $product->id)
                                            <div class="carousel-item {{ $isMainImage ? 'active' : '' }}">
                                                <img src="{{ file_exists(public_path('productImages' . $image->image)) ? asset('productImages' . $image->image) : asset('img/not_found.png') }}"
                                                     class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                                     alt="{{ asset('img/not_found.png') }}">
                                            </div>

                                            @php
                                                $isMainImage = false;
                                            @endphp
                                        @endif
                                    @endforeach

                                </div>

                                    <!-- Indicatori -->
                                    <div class="carousel-indicators position-static mt-2">
                                        @php
                                            $indicatorIndex = 0;
                                        @endphp
                                        @foreach($images as $image)
                                            @if($image->product_id == $product->id)
                                                <button type="button"
                                                        data-bs-target="#carousel-{{ $product->id }}"
                                                        data-bs-slide-to="{{ $indicatorIndex }}"
                                                        class="{{ $indicatorIndex === 0 ? 'active' : '' }} mx-1"
                                                        style="width: 10px; height: 10px; border-radius: 50%; border: none; background-color: #D0A1FF;">
                                                </button>
                                                @php
                                                    $indicatorIndex++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </div>


                                <!-- Controlli -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                    </button>
                            </div>
                        @endif
                    </div>

                    <!-- Corpo della card -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Colore:</strong> {{ $product->color }}</li>
                            <li class="list-group-item"><strong>Data di rilascio:</strong> {{ $product->release_date }}</li>
                            <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }} €</li>
                        </ul>
                    </div>

                    <!-- Footer della card -->
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn w-100" style="background-color: #D0A1FF">Dettagli</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
@include('templates.footer')



<!-- Stile aggiuntivo -->
<style>
    .carousel {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s ease;
    }

    .carousel:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .carousel-inner {
        transition: transform 0.5s ease;
    }
    .carousel-item img {
        transition: transform 0.5s ease;
    }
    .carousel:hover .carousel-item.active img {
        transform: scale(1.02);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        opacity: 0;
        transition: all 0.3s ease;
        margin: 0 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .carousel:hover .carousel-control-prev,
    .carousel:hover .carousel-control-next {
        opacity: 1;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(255, 255, 255, 0.95);
        transform: translateY(-50%) scale(1.05);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-image: none;
        width: 20px;
        height: 20px;
        background-color: #333;
        mask-repeat: no-repeat;
        mask-position: center;
    }
    .carousel-control-prev-icon {
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
    }
    .carousel-control-next-icon {
        mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
    }

    .carousel-indicators {
        bottom: 15px;
    }
    .carousel-indicators [data-bs-target] {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
        margin: 0 4px;
        transition: all 0.3s ease;
    }
    .carousel-indicators .active {
        background-color: #fff;
        transform: scale(1.2);
    }
</style>
