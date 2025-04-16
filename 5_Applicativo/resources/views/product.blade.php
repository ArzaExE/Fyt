<!-- Header -->
@include('templates.header')

<main class="flex-grow-1">
    <!-- Contenuto principale -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Card del prodotto -->
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <!-- Sezione Immagini -->
                        <div class="col-md-6">
                            @if($images->count() > 0)
                                <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="ratio ratio-1x1 overflow-hidden rounded-3"
                                         style="border: 1px solid #e0e0e0;">
                                        @foreach($images as $image)
                                            @if($image->product_id == $product->id)
                                                @php
                                                    $isMainImage = $image->is_main;
                                                @endphp
                                                <div class="carousel-item {{ $isMainImage ? 'active' : '' }}">
                                                    <img
                                                        src="{{ file_exists(public_path('productImages' . $image->image)) ? asset('productImages' . $image->image) : asset('img/not_found.png') }}"
                                                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                                        alt="{{ asset('img/not_found.png') }}">
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>

                                    <div class="carousel-indicators position-static mt-2">
                                        @php
                                            $indicatorIndex = 0;
                                        @endphp
                                        @foreach($images as $image)
                                            @if($image->product_id == $product->id)
                                                <button type="button"
                                                        data-bs-target="#carousel-{{ $product->id }}"
                                                        data-bs-slide-to="{{ $indicatorIndex }}"
                                                        class="{{ $image->is_main ? 'active' : '' }} mx-1"
                                                        style="width: 10px; height: 10px; border-radius: 50%; border: none; background-color: #D0A1FF;">
                                                </button>
                                                @php
                                                    $indicatorIndex++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Controlli -->
                                    <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                                          aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                                          aria-hidden="true"></span>
                                    </button>

                                </div>
                            @else
                                <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('img/not_found.png') }}" class="img-fluid p-5"
                                         alt="Immagine non disponibile">
                                </div>
                            @endif
                        </div>

                        <!-- Sezione Dettagli -->
                        <div class="col-md-6">
                            <div class="card-body h-100 d-flex flex-column">
                                <h1 class="card-title display-5 mb-4">{{ $product->name }}</h1>

                                <!-- Tabella Dettagli -->
                                <div class="table-responsive mb-4">
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr>
                                            <th class="w-25" scope="row">Colore</th>
                                            <td>
                                                <span class="d-inline-block rounded-circle me-2"
                                                      style="width: 15px; height: 15px; background-color: #D0A1FF"></span>
                                                {{ $product->color }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Descrizione</th>
                                            <td>{{ $product->description }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Data di rilascio</th>
                                            <td>{{ $product->formatted_release_date }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Prezzo</th>
                                            <td class="h5">{{ number_format($product->price, 2) }} €</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Disponibilità</th>
                                            <td>
                                                @php
                                                    $totaleProdotti = 0;
                                                @endphp
                                                @if($sizes)
                                                    @foreach($sizes as $size)
                                                        @php
                                                            $totaleProdotti += $size->stock;
                                                        @endphp
                                                  @endforeach
                                                @endif
                                                <span class="badge {{ $totaleProdotti > 0 ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $totaleProdotti > 0 ? 'Disponibile' : 'Esaurito' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            @if($totaleProdotti > 0)
                                                <th scope="row">Taglie</th>
                                            @endif
                                            @if($sizes)
                                                    @foreach($sizes as $size)
                                                        <td>{{ $size->size }}</td>
                                                    @endforeach
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Azioni -->
                                <div class="mt-auto">
                                    <button class="btn w-100 mb-2" style="background-color: #D0A1FF; color: white;">
                                        <i class="bi bi-cart-plus me-2"></i>Aggiungi al carrello
                                    </button>
                                    <a href="{{ route('catalog') }}" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-left me-2"></i>Torna al catalogo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Footer -->
@include('templates.footer')

<!-- Stile aggiuntivo -->
<style>
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    th {
        color: #6c757d;
        font-weight: 500;
    }

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
