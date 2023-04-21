@extends('frontend.layouts.app')

@section('content')

     <!--slider area start-->
     <section class="slider_section slider_section_three">

            <div class="slider_area owl-carousel">
                @foreach($sliders as $slide)
                    <div class="single_slider d-flex align-items-center" data-bgimg="{{asset($slide->image_path)}}">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="slider_content slider_c_three">
                                        <h1>{{$slide->title}}</h1>
                                        <p>{{$slide->caption}}</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

     </section>
     <!--slider area end-->

      <!--brand newsletter area start-->
      {{-- <div class="brand_area brand_three">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand_container owl-carousel">
                        @foreach($brands as $brand)
                            <div class="single_brand">
                                <a href="#"><img src="{{asset($brand->image_path)}}" alt=""></a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--brand area end-->


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

    <!--banner area start-->
    <div class="banner_area banner_three pt-70 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style3">
                        <h3>Featured Category</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="single_banner">
                            <div class="banner_thumb">
                                <a href="{{ route('products',$category->slug) }}"><img src="{{asset($category->image_path)}}" alt=""></a>
                                <div class="banner_text">
                                    <a href="{{ route('products',$category->slug) }}">{{$category->title}}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!--banner area end-->

     <!--new product area start-->
     <section class="product_area product_three mt-70 mb-40">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style3">
                        <h3>Our Products</h3>
                    </div>
                    <div class="product_tab_btn3">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#electronics" role="tab" aria-controls="electronics" aria-selected="true">
                                    Electronics
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#womens-fashion" role="tab" aria-controls="womens-fashion" aria-selected="false">
                                    Women's Fashion
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#mens-fashion" role="tab" aria-controls="mens-fashion" aria-selected="false">
                                    Men's Fashion
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <div class="product_wrapper product_color3">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="electronics" role="tabpanel">
                        <div class="row product_slick_row4">
                            @foreach($products as $product)
                            @if($product->category)
                                @if($product->category->slug =='electronics')
                                    <div class="col-lg-3">

                                        <div class="single_product">

                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->image_path)}}" alt=""></a>


                                                    <div class="action_links">
                                                        <ul>
                                                            @if(!empty(Auth::guard('customer')->user()))
                                                                <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$product->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                            @else
                                                                <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                            @endif
                                                            <li ><a href="#" class="view-quickview" data-product_id="{{$product->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="product_content">
                                                    <div class="product_name">
                                                        <h4><a href="{{ route('products.detail', $product->slug) }}">{{$product->title}}</a></h4>
                                                    </div>

                                                    <div class="price-container">
                                                        <div class="price_box">
                                                            <span class="current_price">Rs {{$product->price}}</span>

                                                        </div>

                                                    </div>

                                                </div>

                                        </div>

                                    </div>
                                @endif
                            @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="tab-pane fade" id="womens-fashion" role="tabpanel">
                        <div class="row product_slick_row4">
                            @foreach($products as $product)
                            @if($product->category->slug =='womens-fashion')
                                <div class="col-lg-3">

                                    <div class="single_product">

                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->image_path)}}" alt=""></a>
                                                <a class="secondary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->banner_path)}}" alt=""></a>

                                                <div class="action_links">
                                                    <ul>
                                                        @if(!empty(Auth::guard('customer')->user()))
                                                            <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$product->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @else
                                                            <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @endif
                                                        <li ><a href="#" class="view-quickview" data-product_id="{{$product->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_content">
                                                <div class="product_name">
                                                    <h4><a href="{{ route('products.detail', $product->slug) }}">{{$product->title}}</a></h4>
                                                </div>

                                                <div class="price-container">
                                                    <div class="price_box">
                                                        <span class="current_price">Rs {{$product->price}}</span>

                                                    </div>

                                                </div>

                                            </div>

                                    </div>

                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="mens-fashion" role="tabpanel">
                        <div class="row product_slick_row4">
                            @foreach($products as $product)
                            @if($product->category->slug =='mens-fashion')
                                <div class="col-lg-3">

                                    <div class="single_product">

                                            <div class="product_thumb">
                                                <a class="primary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->image_path)}}" alt=""></a>
                                                <a class="secondary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->banner_path)}}" alt=""></a>

                                                <div class="action_links">
                                                    <ul>
                                                        @if(!empty(Auth::guard('customer')->user()))
                                                            <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$product->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @else
                                                            <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                        @endif
                                                        <li ><a href="#" class="view-quickview" data-product_id="{{$product->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_content">
                                                <div class="product_name">
                                                    <h4><a href="{{ route('products.detail', $product->slug) }}">{{$product->title}}</a></h4>
                                                </div>

                                                <div class="price-container">
                                                    <div class="price_box">
                                                        <span class="current_price">Rs {{$product->price}}</span>

                                                    </div>

                                                </div>

                                            </div>

                                    </div>

                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--new product area end-->

      <!--banner fullwidth area start-->
      <div class="banner_fullwidth">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="banner_thumb">
                        <a href="https://demo.hasthemes.com/alista-preview/alista/shop.html"><img src="https://demo.hasthemes.com/alista-preview/alista/assets/img/bg/banner21.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--banner fullwidth area end-->



    <!--new product area start-->
    <section class="product_area product_three mb-40">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title title_style3">
                        <h3> Best Sellers</h3>
                    </div>
                </div>
            </div>
            <div class="product_wrapper product_color3">
                <div class="row product_slick_column3">
                    @foreach($bestsellerproducts as $product)


                            <div class="col-lg-3">
                                <div class="single_product">

                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('products.detail', $product->slug) }}"><img src="{{asset($product->image_path)}}" alt=""></a>


                                        <div class="action_links">
                                            <ul>
                                                @if(!empty(Auth::guard('customer')->user()))
                                                    <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$product->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                @else
                                                    <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                @endif
                                                <li ><a href="#" class="view-quickview" data-product_id="{{$product->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_content">
                                        <div class="product_name">
                                            <h4><a href="{{ route('products.detail', $product->slug) }}">{{$product->title}}</a></h4>
                                        </div>

                                        <div class="price-container">
                                            <div class="price_box">
                                                <span class="current_price">Rs {{$product->price}}</span>

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
    <!--new product area end-->




        <!--services img area-->
    {{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title title_style3">
                    <h3> Our Services</h3>
                </div>
            </div>
        </div>
        <div class="services_gallery mt-60">
            <div class="container">
                <div class="row">
                    @foreach ($trainings as $training)
                        <div class="col-lg-4 col-md-6">
                            <div class="single_services">
                                <div class="services_thumb">
                                    <a href="{{ route('trainings.detail', $training->slug) }}"> <img src="{{asset($training->image_path)}}" alt="">
                                </div>
                                <div class="services_content">
                                <h3>{{$training->title}}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
    <!--services img end-->

@stop

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

           }
       })
   });
</script>

@endpush
