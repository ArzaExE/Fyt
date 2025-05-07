<!-- Header -->
@include('templates.header')

<div class="container mt-5">
    <h2>Ultime uscite</h2>
    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(array_chunk($images->all(), 5) as $imageChunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                    <div class="row justify-content-center">
                        @foreach($imageChunk as $image)
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <img src="{{ file_exists(public_path('productImages/' . $image->image)) ? asset('productImages/' . $image->image) : asset('img/not_found.png') }}"
                                     class="w-100 h-100 object-fit-cover"
                                     alt="{{ asset('img/not_found.png') }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Footer -->
@include('templates.footer')
