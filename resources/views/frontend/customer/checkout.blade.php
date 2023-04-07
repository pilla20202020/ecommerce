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
                        <li><a href="{{route('checkout')}}">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->


<!--Checkout page section-->
<div class="Checkout_section">
   <div class="container">
        <div class="row">
           <div class="col-12">
                <div class="user-actions">
                    <h3>

                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Returning customer?
                        <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_login" aria-expanded="true">Click here to login</a>

                    </h3>
                     <div id="checkout_login" class="collapse" data-parent="#accordion">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>
                            <form action="{{ route('customer-login') }}" method="POST">
                                @csrf
                                <div class="form_group">
                                    <label>Username or email <span>*</span></label>
                                    <input type="text" class="form-control" id="singin-email"
                                    name="email" placeholder="Email Address *"
                                    required value="{{old('email')}}"/>
                                </div>
                                <div class="form_group">
                                    <label>Password  <span>*</span></label>
                                    <input type="password" class="form-control" id="singin-password"
                                    name="password" placeholder="Password *" required />
                                </div>
                                <div class="form_group">
                                    <button class="btn btn-dark btn-block btn-rounded"
                                    type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

           </div>
        </div>
        <div class="checkout_form">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <form action="{{ route('order') }}" class="form" method="POST" id="myform">
                        @csrf
                        <h3>Billing Details</h3>
                        <div class="row">
                            @if (Auth::guard('customer')->user())
                                <div class="col-lg-6 mb-20">
                                    <label>Full Name <span>*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                    value="{{ Auth::guard('customer')->user()->name }}"/>
                                </div>
                            @else
                                <div class="col-lg-6 mb-20">
                                    <label>First Name <span>*</span></label>
                                    <input name="name" type="text">
                                </div>
                            @endif

                            <div class="col-12 mb-20">
                                <label>Address  <span>*</span></label>
                                <input name="address" placeholder="House number and street name" type="text" value="{{ Auth::guard('customer')->user()->address }}">
                            </div>

                            <div class="col-lg-6 mb-20">
                                <label>Phone<span>*</span></label>
                                <input name="phone" placeholder="House number and street name" type="text" value="{{ Auth::guard('customer')->user()->phone }}" required>


                            </div>
                             <div class="col-lg-6 mb-20">
                                <label> Email Address   <span>*</span></label>
                                <input type="text" name="email" class="form-control" required
                                value="{{ Auth::guard('customer')->user()->email }}"/>

                            </div>


                            <div class="col-12">
                                <div class="order-notes">
                                     <label for="order_note">Order Notes</label>
                                    <textarea name="order_note" id="order_note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="col-lg-6 col-md-6">
                                <h3>Your order</h3>
                                <div class="order_table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($carts as $cart)
                                            <tr>
                                                <td> {{$cart->product->title}}<strong> × {{$cart->quantity}}</strong></td>
                                                <td> Rs.{{$cart->amount}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cart Subtotal</th>
                                                <td>Rs. {{$total}}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td><strong>Rs. {{setting('shipping_charge')}}</strong></td>
                                            </tr>
                                            <tr class="order_total">
                                                <th>Order Total</th>
                                                <td><strong>Rs. {{$total_amount}}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="payment_method">
                                    <h3>Shipping Details</h3>
                                    <div class="payment accordion radio-type sumnary-shipping">
                                        <h4 class="summary-subtitle ls-m">Preferred Delivery Date</h4>
                                        <div class="select-box">
                                            <input id="preferred_delivery_date" name="preferred_delivery_date" class="form-control mb-3" type="date" required>
                                        </div>

                                        <h4 class="summary-subtitle ls-m">Delivery Time Slot</h4>
                                        <div class="select-box mb-3" id="timeslot" >
                                            <select  class="form-control"  name="timeslot">
                                                <option value="">Select Time Slot</option>
                                                <option value="12pm-3pm">12pm-3pm</option>
                                                <option value="3pm-6pm">3pm-6pm</option>
                                                <option value="6pm-12am">6pm-12am</option>

                                            </select>
                                        </div>

                                        <h4 class="summary-subtitle ls-m">Payment Method</h4>
                                        <div class="select-box pb-2" id="timeslot" >
                                            <select  class="form-control"  name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="cash-on-delivery">Cash on Delivery </option>
                                                {{-- <option value="esewa">Esewa</option> --}}

                                            </select>
                                        </div>

                                    </div>

                                    <div class="order_button">
                                        <button  type="submit">Proceed to Pay</button>
                                    </div>
                                </div>
                        </div>
                    </form>
            </div>
        </div>

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
                            @foreach($customer_recommend_product as $product)
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
                                                    <span class="current_price">Rs {{$product['price']}}</span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </section>
        @endif
    <!--recommended product area end-->
    </div>
</div>
<!--Checkout page section end-->

@endsection

@push('scripts')
<script>
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
