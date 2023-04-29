@extends ('frontend.layouts.app')
@section('content')

   <!--breadcrumbs area start-->
   <div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="">All CART</a></li>
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
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                            <th class="product_remove">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($carts as $cart)
                                            <tr>
                                                <td class="product_thumb"><a href="#"><img src="{{asset($cart->product->image_path)}}" alt=""></a></td>
                                                <td class="product_name"><a href="#">{{$cart->product->title}}</a></td>
                                                <td class="product-price">{{$cart->product->price}}</td>
                                                <td class="product-quantity">
                                                    <div class="input-group">
                                                        <input type="hidden" id="cartid" class= "cartid" name="id[]" value="{{ $cart->id }}" />
                                                        <button type="button" class="quantity-minus d-icon-minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                        <input name="quantity[]" class="quantity" type="number" min="1"
                                                            max="1000000" value="{{ $cart->quantity }}">
                                                        <button type="button" class="quantity-plus d-icon-plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                    </div>
                                                </td>
                                                <td class="product-price">
                                                    <span class="cart-amount">Rs {{ number_format($cart->amount) }}</span>
                                                </td>
                                                <td class="product_remove">
                                                    <a href="{{ route('delete-cart', $cart->id) }}" class="product_remove" title="Remove this product">
                                                        <i class="fas fa-times"></i>
                                                    </a>
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

        <!--recommended product area start-->
        @if(isset($customer_recommend_product))

            <section class="product_area product_three mb-40">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="section_title title_style3">
                                <h3> Recommend For You</h3>
                            </div>
                        </div>
                    </div>
                    <div class="product_wrapper product_color3">
                        <div class="row product_slick_column3">
                            <?php $i = 0; ?>
                            @foreach($customer_recommend_product as $key => $product)
                                @if($i < 3)
                                    <div class="col-lg-3">
                                        <div class="single_product">
                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('products.detail', $product['slug']) }}"><img src="{{asset($product['image_path'])}}" alt=""></a>
                                                <div class="action_links">
                                                    <ul>
                                                        @if(!empty(Auth::guard('customer')->user()))
                                                            <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$product['id']}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @else
                                                            <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @endif
                                                        <li ><a href="#" class="view-quickview" data-product_id="{{$product['id']}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_content">
                                                <div class="product_name">
                                                    <h4><a href="{{ route('products.detail', $product['slug']) }}">{{$product['title']}}</a></h4>
                                                </div>

                                                <div class="price-container">
                                                    <div class="price_box">
                                                        <span class="current_price">Rs {{$product['price']}}</span><br>
                                                        @if(isset($similarity_score[$i])) 
                                                            <span class="current_price"> {{$similarity_score[$i]}}</span>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @endif
                                <?php $i++ ?>
                                
                            @endforeach


                        </div>
                    </div>
                </div>
            </section>
        @endif
    <!--recommended product area end-->
    </div>
</div>
<!--shopping cart area end -->

@endsection

@push('scripts')
<script>

    $(document).on('click','.quantity-minus',function(e){
        var product_quantity = $(this).next().val();
        if(product_quantity > 1) {
            var new_quantity = --product_quantity;
            $(this).next().val(new_quantity);
        } else {
            alert("The Minimum quantity must be greater than or equal to 1.")
        }

    })


    $(document).on('click','.quantity-plus',function(e){
        var product_quantity = $(this).prev().val();
        var new_quantity = ++product_quantity;
        $(this).prev().val(new_quantity);
    })



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

   $(document).on('click','.addtocart',function(e){
       e.preventDefault();
       var qty = 1;
       var product_id = Number($(this).data('id'));
       var id = $('.id').val();
       console.log(qty);
       $.ajax({
           url: "{{route('add-to-cart')}}",
           method: 'post',
           data: {
               _token: '{{csrf_token()}}',
               quantity: qty,
               product_id: product_id,
               id:id,
               // price: $('.totalpricing').val(),
           },
           success:function(data){
               $('.listitems').html(data);
               var totalprice = $('.totalpricing').html();
               $('.cart-price').html(totalprice);

               var totalcount = $('.totalcounting').val();
               $('.cart-count').html(totalcount)

               Swal.fire(
                        'Added to cart',
                        '',
                        'success'
                    )
                    setTimeout(function() {
                                    window.location.reload();
                                }, 1500);

           }
       })
    });
</script>
@endpush
