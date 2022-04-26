@extends ('frontend.layouts.app')
@section('content')

<div class="order-results">
    <div class="overview-item">
        <span>Order number:</span>
        <strong>{{ $order_details->order_number }}</strong>
    </div>
    <div class="overview-item">
        <span>Order Total:</span>
        <strong>Rs {{ number_format($order_details->total_amount, 2) }}</strong>
    </div>
    {{-- <div class="overview-item">
        <span>Order Date:</span>
        <strong>{{ $order_details->ordered_date }}</strong>
    </div> --}}
    {{-- <div class="overview-item">
        <span>Payment method:</span>
        <strong>{{ $order_details->payment_method_label }}</strong>
    </div> --}}
    <div class="overview-item">
        <span>Payment Status:</span>
        <strong>{{ $order_details->payment_status }}</strong>
    </div>
</div>

<h2 class="title title-simple text-left pt-4 font-weight-bold text-uppercase">Order Details</h2>
        <div class="order-details">
            <table class="order-details-table">
                <thead>
                    <tr class="summary-subtotal">
                        <td>
                            <h3 class="summary-subtitle">Product</h3>
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($order_details->orderItems as $items)
                    <tr>
                        <td class="product-name">{{ $items->name }} <span> <i class="fas fa-times"></i>
                        {{ $items->quantity }}</span></td>
                        <td class="product-price">Rs {{ number_format($items->rate * $items->quantity, 2) }}</td>
                    </tr>
                    @endforeach --}}

                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Subtotal:</h4>
                        </td>
                        <td class="summary-subtotal-price">Rs {{ number_format($order_details->sub_total, 2) }}</td>
                    </tr>
                    @if ($order_details->discount_amount > 0)
                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Discount:</h4>
                        </td>
                        <td class="summary-subtotal-price">Rs {{ number_format($order_details->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Shipping:</h4>
                        </td>
                        <td class="summary-subtotal-price">{{ $order_details->shipping_method_name }}
                            @if ($order_details->shipping_cost > 0)
                             - Rs {{ number_format($order_details->shipping_cost, 2) }}
                            @endif
                        </td>
                    </tr>
                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Preferred Delivery Date:</h4>
                        </td>
                        <td class="summary-subtotal-price">{{ $order_details->formatted_preferred_delivery_date }}</td>
                    </tr>
                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Payment method:</h4>
                        </td>
                        <td class="summary-subtotal-price">{{ $order_details->payment_method_label }}</td>
                    </tr>
                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle">Total:</h4>
                        </td>
                        <td>
                            <p class="summary-total-price">Rs {{ number_format($order_details->total_amount, 2) }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection