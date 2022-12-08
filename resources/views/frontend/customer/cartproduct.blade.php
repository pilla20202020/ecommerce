<input type="hidden" class="totalcounting" value="@if((isset($carts))) {{ $carts->sum('quantity') }} @endif">

<!--mini cart-->
  <div class="mini_cart">
    @if((isset($carts)))
    @foreach($carts as $cart)
        <div class="cart_item">
            <div class="cart_img">
                <a href="#"><img src="{{asset($cart->product->image_path)}}" alt=""></a>
            </div>
            <div class="cart_info">
                <a href="#">{{ $cart->product->title }}</a>

                <span class="quantity">Qty: {{ $cart->quantity }}</span>
                <span class="price_cart">Rs {{ number_format($cart->price) }}</span>

            </div>
            <div class="cart_remove">
                <button onclick="location.href = &quot;{{ route('delete-cart', $cart->id) }}&quot;;" class="btn btn-link btn-close">
                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                </button>
            </div>
        </div>  
       
    @endforeach
    @endif
    <div class="mini_cart_table">
        <div class="cart_total">
            <span>Subtotal:</span>
            <span class="totalpricing">Rs {{ number_format($carts->sum('amount')) }}</span>
        </div>
    </div>
    <div class="mini_cart_footer">
        <div class="cart_button">
                <a href="{{route('view-cart')}}">View cart</a>
                <a href="{{route('checkout')}}">Checkout</a>
            </div>
        </div>
</div>
<!--mini cart end-->