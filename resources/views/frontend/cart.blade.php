@extends ('frontend.layouts.app')
@section('content')

   <!--breadcrumbs area start-->
   <div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="cart.html">cart page</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--shopping cart area start -->
<div class="shopping_cart_area">
    <div class="container">
        <form action="#">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                            <div class="cart_page table-responsive">
                            <form method="POST" action="{{ route('update-cart') }}">
                                @csrf
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($carts as $cart)
                                            <tr>
                                                <td class="product_remove">
                                                    <a href="{{ route('delete-cart', $cart->id) }}" class="product_remove" title="Remove this product">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                                <td class="product_thumb"><a href="#"><img src="{{asset($cart->product->image_path)}}" alt=""></a></td>
                                                <td class="product_name"><a href="#">{{$cart->product->title}}</a></td>
                                                <td class="product-price">{{$cart->product->price}}</td>
                                                <td class="product-quantity">
                                                    <div class="input-group">
                                                        <input type="hidden" id="cartid" class= "cartid" name="id[]" value="{{ $cart->id }}" />
                                                        <button type="button" class="quantity-minus d-icon-minus"></button>
                                                        <input name="quantity[]" class="quantity" type="number" min="1"
                                                            max="1000000" value="{{ $cart->quantity }}">
                                                        <button type="button" class="quantity-plus d-icon-plus"></button>
                                                    </div>
                                                </td>
                                                <td class="product-price">
                                                    <span class="cart-amount">Rs {{ number_format($cart->amount) }}</span>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart_submit">
                                <a href="javascript:;"  class="btn btn-outline btn-dark btn-md btn-rounded updatecart">
                                    Update
                                </a>
                            </div>
                             </form>
                    </div>
                 </div>
             </div>
             <!--coupon code area start-->
            <div class="coupon_area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                               <div class="cart_subtotal">
                                   <p>Subtotal</p>
                                   <p class="cart_amount">Rs. {{ number_format($carts->sum('amount')) }}</p>
                               </div>

                               <a href="#">Calculate shipping</a>

                               <div class="checkout_btn">
                                   <a href="{{ route('checkout') }}">Proceed to Checkout</a>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area end-->
        </form>
    </div>
</div>
<!--shopping cart area end -->

@endsection

@push('scripts')
<script>
    $(document).on('click','.updatecart',function(e){
        e.preventDefault();
        var item = [];
        var i=0;
        $('input[name="id[]"]').each(function() {
                item[i]=(this.value);
                i++;
        });
        var quantity = [];
        var i=0;
        $('input[name="quantity[]"]').each(function() {
                quantity[i]=(this.value);
                i++;
        });
            $.ajax({
           url: "{{route('update-cart')}}",
           method: 'post',
           data: {
               _token: '{{csrf_token()}}',
               quantity: quantity,
               id: item,
           },
           success:function(data){
               $('.product-price').html(data);
               Swal.fire(
                        'Updated to cart',
                        '',
                        'success'
                    );
                setTimeout(location.reload.bind(location), 500);

           }
       })


   });
</script>
@endpush
