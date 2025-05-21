<!-- Header -->
@include('templates.header')
@php
    // Funzione che pemette di controllare se una parola corrisponde a un colore che possa essere usato come per esempio background-color
    function isColorName($color) {
        $colors = [
            'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure',
            'beige', 'bisque', 'black', 'blanchedalmond', 'blue',
            'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse',
            'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson',
            'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray',
            'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange',
            'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue',
            'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue',
            'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen',
            'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod',
            'gray', 'green', 'greenyellow', 'honeydew', 'hotpink',
            'indianred', 'indigo', 'ivory', 'khaki', 'lavender',
            'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral',
            'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightpink',
            'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue',
            'lightyellow', 'lime', 'limegreen', 'linen', 'magenta',
            'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple',
            'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred',
            'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite',
            'navy', 'oldlace', 'olive', 'olivedrab', 'orange',
            'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise',
            'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink',
            'plum', 'powderblue', 'purple', 'red', 'rosybrown',
            'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen',
            'seashell', 'sienna', 'silver', 'skyblue', 'slateblue',
            'slategray', 'snow', 'springgreen', 'steelblue', 'tan',
            'teal', 'thistle', 'tomato', 'turquoise', 'violet',
            'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen'
        ];

        return in_array(strtolower($color), $colors);
    }
@endphp

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
                                                <th class="w-25" scope="row">Color</th>
                                                <td>
                                                    @if(isColorName($product->color))
                                                        <span class="d-inline-block rounded-circle me-2"
                                                              style="width: 15px; height: 15px; background-color: {{$product->color}}"></span>
                                                        {{ $product->color }}
                                                    @else
                                                        <span class="d-inline-block rounded-circle me-2"
                                                              style="width: 15px; height: 15px; background-color: gray"></span>
                                                        {{ $product->color }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Description</th>
                                                <td>{{ $product->description }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Release Date</th>
                                                <td>{{ $product->formatted_release_date }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Price</th>
                                                <td class="h5">{{ number_format($product->price, 2) }} €</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Availability</th>
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
                                                            {{ $totaleProdotti > 0 ? 'Available' : 'Not Available' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                @if($totaleProdotti > 0)
                                                    <th scope="row">Sizes</th>
                                                    <td colspan="{{ count($sizes) }}">
                                                        <select name="selected_size" class="form-control">
                                                            @foreach($sizes as $size)
                                                                @if($size->stock > 0)
                                                                    <option value="{{ $size->size }}">{{ $size->size }}</option>
                                                                @endif
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
                                            {{ $totaleProdotti > 0 ? 'Add to cart' : 'Sold out' }}
                                        </button>
                                        <a href="/catalog" class="btn btn-outline-secondary w-100">
                                            <i class="bi bi-arrow-left me-2"></i>Back to the catalog
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
