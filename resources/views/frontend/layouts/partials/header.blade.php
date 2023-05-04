<!--header area start-->
<header class="header_area">
    <!--header top area start-->
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header_top_right">

                        <div class="header_social">
                            <ul>
                                <li><a href="{{setting('facebook')}}"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top area end -->

    <!--header middle area start-->
    <div class="header_middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-12">
                    <div class="logo logo_three">
                        <a href="{{ route('homepage') }}"><img src="{{ asset('assets/images/logo.png') }}" width="65%" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-12">
                    <div class="header_middle_right">
                        <div class="header_contact">
                            <div class="contact_static">
                                <a href="tel:{{setting('phone')}}"><i class="ion-android-call"></i> Call Us: {{setting('phone')}}</a>

                            </div>
                            <div class="contact_static">
                                <a href="mailto:{{setting('email')}}"><i class="ion-android-mail"></i> {{setting('email')}}</a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="header_middle_right">
                        <div class="header_contact">

                            @if (Auth::guard('customer')->user())

                                <div class="contact_static">
                                    <a href="{{ route('my-account') }}"><i class="ion-person"></i>My Account </a>
                                </div>
                                <div class="contact_static">
                                    <a href="{{ route('customer-logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Log out
                                    </a>

                                </div>
                                <form id="logout-form" action="{{ route('customer-logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <div class="contact_static">
                                    <a href="{{ route('user-login') }}"><i class="ion-person"></i>Login</a>
                                </div>
                                <div class="contact_static">
                                    <a href="{{ route('user-register') }}"><i class="ion-person"></i>Register</a>

                                </div>
                            @endif
                            <div class="mini_cart_wrapper mini_cart_three">
                                <span class="cart-price">Rs {{ number_format($carts->sum('amount')) }}</span>
                                 <a href="javascript:void(0)">
                                     <i class="ion-bag">
                                    </i>
                                        <input type="hidden" name="quantity" id="quantity" value="{{$carts->sum('quantity')}}">
                                        <span class="cart-count">{{ $carts->sum('quantity') }}</span>

                                </a>
                                <ul class="listitems">
                                    @include('frontend.customer.cartproduct')
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header middle area end-->

    <!--header bottom start-->

{{-- menu --}}
<div class="header_bottom sticky-header">
    <div class="container">
        <div class="header_container_right container_position">
            <div class="main_menu menu_three">
                <nav>
                    <ul>
                        <li><a  href="{{ route('homepage') }}"> Home</a>

                        </li>
                        <li class="mega_items"><a href="{{route('listAllProduct')}}">Products</a>
                            <div class="mega_menu">
                                <ul class="mega_menu_inner">

                                    @foreach($categories as $category)
                                        <li><a href="{{ route('products',$category->slug) }}" class="{{  (request()->is("*".$category->slug."*")) ? 'active getcurrentactive' : '' }}">{{$category->title}}</a>
                                            <ul>
                                                <li>
                                                    @foreach($subcategories as $subcategory)
                                                        @if($category->id == $subcategory->category->id)
                                                            <a href="{{ route('all-products',$subcategory->slug) }}" >{{$subcategory->title}}</a>
                                                        @endif
                                                    @endforeach

                                                </li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>



                        </li>
                        <li><a href="{{ route('about') }}"> About Us</a></li>
                        <li><a href="{{ route('contact') }}"> Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="header_block_right">
                <ul>
                    <li class="search_bar"><a href="javascript:void(0)"><i class="ion-ios-search-strong"></i></a> </li>
                </ul>
            </div>
        </div>
    </div>
    <!--header bottom end-->
</div>
</header>
<!--header area end-->
<!--search overlay-->

<div class="dropdown_search dropdown_search_three">
    <div class="search_close_btn">
        <i class="ion-android-close btn-close"></i>
    </div>
    <div class="search_container">
        <form action="{{route('search')}}">
            <input name="keyword" placeholder="Search here…" type="text">
            <button type="submit"><i class="ion-ios-search-strong"></i></button>
        </form>
    </div>
</div>

<!--search overlay end-->

   <!--Offcanvas menu area start-->

   <div class="off_canvars_overlay">

</div>
<div class="Offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <span>MENU</span>
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                          <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>

                    <div class="header_block_right">
                        <ul>

                            <li class="mini_cart_wrapper"><a href="javascript:void(0)"><i class="ion-bag"></i> <span>2</span></a>

                                <input type="hidden" class="totalcounting" value="{{ $carts->sum('quantity') }}">

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
                                    <div class="mini_cart_table">
                                        <div class="cart_total">
                                            <span>Subtotal:</span>
                                            <span class="totalpricing">Rs {{ number_format($carts->sum('amount')) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                                <a href="cart.html">View cart</a>
                                                <a href="{{route('checkout')}}">Checkout</a>
                                            </div>
                                        </div>
                                </div>
                                <!--mini cart end-->
                            </li>

                        </ul>
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children active">
                                <a href="{{ route('homepage') }}">Home</a>

                            </li>

                            <li class="menu-item-has-children">
                                <a href="#">Products</a>
                                <ul class="sub-menu">
                                    <li class="menu-item-has-children">
                                        @foreach($categories as $category)
                                            <li class="menu-item-has-children"><a href="{{ route('products',$category->slug) }}">{{$category->title}}</a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        @foreach($subcategories as $subcategory)
                                                            @if($category->id == $subcategory->category->id)
                                                                <a href="{{ route('all-products',$subcategory->slug) }}">{{$subcategory->title}}</a>
                                                            @endif
                                                        @endforeach

                                                    </li>
                                                </ul>
                                            </li>
                                        @endforeach
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children active">
                                <a href="{{ route('services') }}">Our Services</a>

                            </li>
                            <li class="menu-item-has-children active">
                                <a href="{{ route('about') }}">About Us</a>

                            </li>
                            <li class="menu-item-has-children active">
                                <a href="{{ route('contact') }}">Contact Us</a>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Offcanvas menu area end-->
