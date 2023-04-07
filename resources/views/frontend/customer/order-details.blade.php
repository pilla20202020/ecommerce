@extends ('frontend.layouts.app')
@section('content')
    <div class="container">

        <h2 class="mt-5">Thank You For Shopping</h2>
        <div class="order-results row mt-2 p-4">
            <div class="overview-item">
                <span>Order number:</span>
                <strong class="pt-2">{{ $order_details->order_number }}</strong>
            </div>
            <div class="overview-item">
                <span>Order Total:</span>
                <strong class="pt-2">Rs {{ number_format($order_details->total_amount, 2) }}</strong>
            </div>
            {{-- <div class="overview-item">
            <span>Order Date:</span>
            <strong>{{ $order_details->ordered_date }}</strong>
        </div> --}}
            <div class="overview-item">
            <span>Payment method:</span>
            <strong class="pt-2">{{ $order_details->payment_method }}</strong>
        </div>
        </div>

        <div class="shopping_cart_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Rate</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order_body">
                                        @foreach ($order_items as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->rate}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->amount}}</td>
                                            </tr>

                                        @endforeach
                                        <tfoot>

                                            <tr class="summary-subtotal">
                                                <td colspan="3">
                                                    <h4 class="summary-subtitle text-right" >Subtotal:</h4>
                                                </td>
                                                <td class="summary-subtotal-price" colspan="3" class="col-lg-offset-2">Rs {{ number_format($order_details->total_amount, 2) }}</td>
                                            </tr>


                                            <tr class="summary-subtotal">
                                                <td colspan="3">
                                                    <h4 class="summary-subtitle text-right">Total:</h4>
                                                </td>
                                                <td  colspan="3">
                                                    <p class="summary-total-price">Rs {{ number_format($order_details->total_amount, 2) }}</p>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>
@endsection
