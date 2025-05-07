<!-- Header -->
@include('templates.header')

<main class="flex-grow-1">
    <!-- Contenuto principale -->
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
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

                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
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
                                                    <span
                                                        class="badge {{ $totaleProdotti > 0 ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $totaleProdotti > 0 ? 'Disponibile' : 'Esaurito' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                @if($totaleProdotti > 0)
                                                    <th scope="row">Taglie</th>
                                                    <td colspan="{{ count($sizes) }}">
                                                        <select name="selected_size" class="form-control">
                                                            @foreach($sizes as $size)
                                                                <option value="{{ $size->size }}">{{ $size->size }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @error('selected_size')
                                    <x-input-error :messages="$message" class="mb-6" />
                                    @enderror
                                    <!-- Azioni -->
                                    <div class="mt-auto">
                                        <button type="submit" class="btn w-100 mb-2"
                                                style="background-color: {{ $totaleProdotti > 0 ? '#D0A1FF' : 'gray' }}; color: white;"
                                            {{ $totaleProdotti > 0 ? '' : 'disabled' }}>
                                            <i class="bi bi-cart-plus me-2"></i>
                                            {{ $totaleProdotti > 0 ? 'Aggiungi al carrello' : 'Esaurito' }}
                                        </button>
                                        <a href="/catalog" class="btn btn-outline-secondary w-100">
                                            <i class="bi bi-arrow-left me-2"></i>Torna al catalogo
                                        </a>
                                    </div>
                                </form>
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

<style>
    /* Stili ereditati dal tuo design */
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
        background-color: #f8f9fa;
    }

    .carousel:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    /* Stili specifici per il carrello */
    .cart-item {
        transition: background-color 0.2s ease;
    }

    .cart-item:hover {
        background-color: #f8f9fa;
    }

    .quantity-controls {
        border-radius: 6px;
        overflow: hidden;
    }

    .quantity-btn {
        transition: all 0.2s ease;
    }

    .quantity-btn:hover {
        background-color: #e9ecef !important;
    }

    .remove-btn {
        transition: transform 0.2s ease;
    }

    .remove-btn:hover {
        transform: scale(1.1);
    }

    .checkout-btn {
        transition: all 0.3s ease;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }

    .continue-shopping {
        transition: all 0.3s ease;
    }
</style>
