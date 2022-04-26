@extends ('frontend.layouts.app')
@section('content')

  
  <!--breadcrumbs area start-->
    
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
               
                    <div class="col-12">
                        <div class="breadcrumb_content">
                            <h3>Products</h3>
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>Search</li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>         
    </div>

   
    
<!--breadcrumbs area end-->

    <!--shop  area start-->
    @if($product)
        <div class="shop_area shop_reverse">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!--shop wrapper start-->
                        <!--shop toolbar start-->
                
                    
                        <div class="shop_toolbar_wrapper">
                            <div class="shop_toolbar_btn">

                                <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>

                                <button data-role="grid_list" type="button"  class="btn-list" data-toggle="tooltip" title="List"></button>
                            </div>
                            <div class=" niceselect_option">

                                <form class="select_option" action="#">
                                    <select name="orderby" id="short">

                                        <option selected value="1">Sort by average rating</option>
                                        <option  value="2">Sort by popularity</option>
                                        <option value="3">Sort by newness</option>
                                        <option value="4">Sort by price: low to high</option>
                                        <option value="5">Sort by price: high to low</option>
                                        <option value="6">Product Name: Z</option>
                                    </select>
                                </form>


                            </div>
                            <div class="page_amount">
                                <p>Showing 1–9 of 21 results</p>
                            </div>
                        </div>
                        <!--shop toolbar end-->
                        
                        @if($product)
                        <div class="row shop_wrapper">
                            @foreach($product as $productsdata)
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="single_product">

                                        <div class="product_thumb">
                                            <a class="primary_img" href="{{ route('products.detail', $productsdata->slug) }}"><img src="{{asset($productsdata->image_path)}}" alt=""></a>
                                            <a class="secondary_img" href="{{ route('products.detail', $productsdata->slug) }}"><img src="{{asset($productsdata->banner_path)}}" alt=""></a>
                                           
                                            <div class="action_links">
                                                <ul>
                                                    @if(!empty(Auth::guard('customer')->user()))
                                                        <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$productsdata->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                    @else
                                                        <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                    @endif
                                                    <li ><a href="#" class="view-quickview" data-product_id="{{$productsdata->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product_content">
                                            <div class="product_name">
                                                <h4><a href="{{ route('products.detail', $productsdata->slug) }}">{{ $productsdata->title}}</a></h4>
                                            </div>
                                            
                                            <div class="price-container">
                                                <div class="price_box">
                                                    <span class="current_price">Rs {{$productsdata->price}}</span>
                                                  
                                                </div>
                                               
                                            </div>

                                        </div>
                                
                                     </div>  
                                </div>
                            @endforeach 
                        </div>
                        @endif

                
                        <!--shop toolbar end-->
                        <!--shop wrapper end-->
                    </div>
                </div>
            </div>
        </div>
    
    @endif   
    <!--shop  area end-->

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
               
           }
       })
   });
</script>

@endpush