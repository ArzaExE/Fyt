@include('templates.header')
<div class="container mt-4">
    <h1 class="h5 font-weight-bold text-dark mb-4">Sales</h1>
    @if(count($orders) > 0)
        @foreach($orders as $order)
            <div class="card mb-3 border-0 shadow-sm">

                <div class="card-header bg-light py-3">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4">
                            <h2 class="h6 mb-0 font-bold">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#clientDetails-{{ $order->user_id }}">
                                    Click here for more infos
                                </a>
                            </h2>
                        </div>

                        <div class="col-md-4">
                            <h2 class="h6 mb-0 font-bold">
                        <span class="badge bg-success-light text-success" style="padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">
                                            {{ ucfirst($order->status) }}
                        </span>
                            </h2>
                        </div>

                        <div class="col-md-4">
                            <h2 class="h6 mb-0 font-bold">
                                Total: {{ number_format($order->total, 2) }} €
                            </h2>
                        </div>
                    </div>
                </div>

                @foreach($order->items as $item)
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body py-2" style="background-color: whitesmoke">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted small">Product: {{ $item->product->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted small">Quantity: {{$item->quantity}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Price: {{number_format($item->price, 2)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="card-body p-3">
            <div class="modal fade" id="clientDetails-{{ $order->user_id }}" tabindex="-1" role="dialog"
                 aria-labelledby="clientDetails-{{ $order->user_id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Client details
                                - {{ $order->user->name }} {{ $order->user->surname }}</h5>
                        </div>
                        <div class="modal-body">
                            <p><b>Order ID: </b> {{ $order->id}}</p>
                            <p><b>Address: </b> {{ $order->user->address }}</p>
                            <p><b>Postcode: </b> {{ $order->user->postcode }}</p>
                            <p><b>City: </b> {{ $order->user->city }}</p>
                            <p><b>Country: </b> {{ $order->user->country }}</p>
                            <p><b>Phone: </b>{{ $order->user->phone }}</p>
                            <p><b>Email: </b> {{ $order->user->email }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    style="background-color: #D0A1FF">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-4 empty-orders">
            <i class="fas fa-box-open text-muted mb-3" style="font-size: 2.5rem;"></i>
            <p class="text-muted mb-2">You don't have any orders yet</p>
        </div>
    @endif
</div>

<style>
    .empty-orders {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 2rem 1rem;
        margin: 1rem 0;
    }

    .bg-success-light {
        background-color: rgba(0, 167, 111, 0.5);
    }

    .bg-danger-light {
        background-color: rgba(255, 86, 48, 0.5);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /*Spaziatura aggiuntiva tra utenti*/
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    /*Mobile*/
    @media (max-width: 768px) {
        .card-body .row > div {
            margin-bottom: 0.5rem;
        }
    }
</style>
