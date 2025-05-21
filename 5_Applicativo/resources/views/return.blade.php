@include('templates.headerNoNav')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <!-- Icona successo -->
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>

                    <h1 class="mb-3">Order Confirmed!</h1>
                    <p class="lead mb-4">Thank you for your purchase. Your order has been successfully processed.</p>

                    <!-- Dettagli ordine -->
                    <div class="bg-light p-4 rounded mb-4 text-start">
                        <h5 class="mb-3">Order Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order Number:</strong><span>#{{$cart->id}}</span>
                                <p><strong>Date:</strong> <?= date('d/m/Y') ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Total:</strong><span id="total"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottone continua lo shopping -->
                    <div class="d-grid gap-2 d-md-block mt-4">
                        <a href="{{route('catalog')}}" class="btn px-4"  style="color: whitesmoke; background-color: #D0A1FF;">Continue Shopping</a>
                        <a href="/orders" class="btn btn-outline-secondary px-4 ms-2">My Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('templates.footer')

