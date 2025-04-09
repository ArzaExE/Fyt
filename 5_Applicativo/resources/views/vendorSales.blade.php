@include('templates.header')
<div class="container mt-4">
    <h1 class="h5 font-weight-bold text-dark mb-4">Sales</h1>

    @foreach($orders as $order)
        <div class="card mb-4 border-0 shadow-sm">
{{--            Div for the username section--}}
            <div class="card-header bg-light py-3">
                <h2 class="h6 mb-0 font-weight-bold">{{ $order->user->name }} {{ $order->user->surname }}</h2>
            </div>
{{--            Div for the orders of a specific user--}}
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Order ID:</span>
                                            <span class="font-weight-bold">{{ $order->id }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Total:</span>
                                            <span class="font-weight-bold">{{ number_format($order->total, 2) }} €</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small">Status:</span>
                                            <span class="badge
                                                @if($order->status == 'paid') bg-success-light text-success
                                                @elseif($order->status == 'pending') bg-danger-light text-danger
                                                @else bg-secondary-light text-secondary
                                                @endif"
                                                  style="padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{--Stile personalizzato--}}
<style>
    .bg-success-light {
        background-color: rgba(0, 167, 111, 0.1);
    }
    .bg-danger-light {
        background-color: rgba(255, 86, 48, 0.1);
    }
    .bg-secondary-light {
        background-color: rgba(99, 115, 129, 0.1);
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /*Mobile*/
    @media (max-width: 768px) {
        .card-body .row > div {
            margin-bottom: 0.5rem;
        }
    }
</style>
