<!-- Header -->
@include('templates.header')

<div class="cart-container">
    <h1 class="cart-title">Il tuo carrello</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($items) > 0)
        <div class="cart-items">
            @foreach($items as $item)
                <div class="cart-item">
                    <div class="product-info">
                        <div class="product-details">
                            <p class="product-name">{{ $item->product->name }}</p>
                            <p class="product-price">{{ number_format($item->product->price, 2) }} €</p>
                        </div>
                    </div>

{{--                    <select class="block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">--}}
{{--                        @foreach($sizes as $key => $value)--}}
{{--                            @if($value == $item->product_id)--}}
{{--                                <option>{{$key}}</option>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

                    <p class="product-price">EU {{$item->size_id}}</p>

                    <div class="quantity-controls">
                        <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_size" id="selected_size" value="{{$item->size_id}}">
                            <button type="submit" id="quantity-remove" name="quantity-remove" class="quantity-btn">−</button>
                        </form>
                        <span class="quantity">{{ $item->quantity }}</span>
                        <form action="{{ route('cart.add', $item->product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_size" id="selected_size" value="{{$item->size_id}}">
                            <button type="submit" id="quantity-add" name="quantity-add" class="quantity-btn">+</button>
                        </form>
                    </div>

{{--                    <x-text-input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="block mt-1" placeholder="Quantity" required />--}}


                    <div class="item-total">
                        {{ number_format($item->price, 2) }} €
                    </div>

                    <form action="{{ route('cart.delete', $item->product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="selected_size" id="selected_size" value="{{$item->size_id}}">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <div class="total-section">
                <h3>Totale provvisorio</h3>
                <p class="total-price">{{ number_format($cart->total, 2) }} €</p>
            </div>
            <button class="checkout-btn">
                <a href="{{ route('checkout.index') }}">Procedi all'acquisto</a>
            </button>
        </div>
    @else
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Il tuo carrello è vuoto</p>
            <a href="/catalog" class="continue-shopping">Continua lo shopping</a>
        </div>
    @endif
</div>

<!-- Footer -->
@include('templates.footer')

<style>
    /* Stili principali */
    .cart-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Segoe UI', sans-serif;
    }

    .cart-title {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
        font-weight: 600;
    }

    /* Stile degli item */
    .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
        gap: 2rem; /* Nuova proprietà per spaziatura uniforme */
    }

    .cart-item:hover {
        background-color: #f9f9f9;
    }

    .product-info {
        display: flex;
        align-items: center;
        flex: 3; /* Più spazio per le info prodotto */
        min-width: 300px;
    }

    .product-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-name {
        margin: 0;
        font-size: 1.1rem;
        color: #333;
        font-weight: 500;
    }

    .product-price {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    /* Controlli quantità */
    .quantity-controls {
        display: flex;
        align-items: center;
        flex: 1;
        justify-content: center;
        gap: 0.8rem; /* Spaziatura tra pulsanti e quantità */
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #ddd;
        background: #fff;
        font-size: 1rem;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: #f0f0f0;
    }

    .quantity {
        min-width: 24px;
        text-align: center;
        font-weight: 500;
    }

    /* Prezzo totale per item */
    .item-total {
        flex: 1;
        text-align: right;
        font-weight: 600;
        color: #333;
        min-width: 100px; /* Larghezza minima garantita */
        padding-right: 1rem;
    }

    /* Pulsante rimuovi */
    .remove-btn {
        background: none;
        border: none;
        color: #ff4444;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.2s;
        padding: 0.5rem;
    }

    .remove-btn:hover {
        color: #cc0000;
    }

    /* Riepilogo carrello */
    .cart-summary {
        margin-top: 3rem;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: right;
    }

    .total-section {
        margin-bottom: 1.5rem;
    }

    .total-price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-top: 0.5rem;
    }

    .checkout-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 14px 28px;
        font-size: 1.1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .checkout-btn:hover {
        background: white;
        border: 1px solid #28a745;
        color: #28a745;
    }

    /* Carrello vuoto */
    .empty-cart {
        text-align: center;
        padding: 5rem 0;
    }

    .empty-cart i {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }

    .empty-cart p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 2rem;
    }

    .continue-shopping {
        color: #D0A1FF;
        text-decoration: none;
        font-weight: 500;
        font-size: 1.1rem;
        padding: 0.75rem 1.5rem;
        border: 1px solid #D0A1FF;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .continue-shopping:hover {
        background-color: #D0A1FF;
        color: white;
        text-decoration: none;
    }
</style>

