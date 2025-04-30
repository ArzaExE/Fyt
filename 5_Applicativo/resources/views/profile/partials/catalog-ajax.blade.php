<!-- Griglia dei prodotti -->
<div class="row">
    @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Carousel Immagini -->
                <div class="p-3">
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
                    @endif
                </div>

                <!-- Corpo della card -->
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ $product->description }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Colore:</strong> {{ $product->color }}</li>
                        <li class="list-group-item"><strong>Data di
                                rilascio:</strong> {{ $product->formatted_release_date }}
                        </li>
                        <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }} €</li>
                    </ul>
                </div>

                <!-- Footer della card -->
                <div class="card-footer bg-transparent">
                    <a href="/catalog/product/{{ $product->id }}" class="btn w-100"
                       style="color: whitesmoke; background-color: #D0A1FF;">Dettagli</a>
                </div>
            </div>
        </div>
    @endforeach

</div>
