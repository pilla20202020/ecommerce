@extends ('frontend.layouts.app')
@section('content')


 <!--breadcrumbs area start-->
 <div class="breadcrumbs_area">
    <div class="container">   
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('homepage') }}">Home</a></li>
                        <li><a href="{{ route('products.detail', $products->slug) }}">{{$products->title}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>         
</div>
<!--breadcrumbs area end-->

<div class="product_container">
    <div class="container">
        <div class="product_container_inner mb-60">
            <!--product details start-->
            <div class="product_details mb-60">
                @if($products)
                
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="product-details-tab">
                                    <div id="img-1" class="zoomWrapper single-zoom" >
                                        <a>
                                            <img id="zoom1" src="{{asset($products->image_path)}}" data-zoom-image="{{asset($products->image_path)}}" alt="big-1">
                                        </a>

                                        
                                    </div>
                                    
                                   
                                    <div class="single-zoom-thumb">
                                           
                                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                                    @if(isset($products->banner_image))
                                                    
                                                        <li>
                                                          
                                                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset($products->banner_path)}}" data-zoom-image="{{asset($products->banner_path)}}" >
                                                                    <img src="{{asset($products->banner_path)}}" alt="ri"/>
                                                                </a>
                                                        
                                                        </li>
                                                    @else 
                                                    {{-- <li>
                                                            
                                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset('assets/images/logo.png')}}" data-zoom-image="{{asset('assets/images/logo.png')}}" >
                                                            <img src="{{asset('assets/images/logo.png')}}" alt="ri"/>
                                                        </a>
                                                
                                                    </li> --}}
                                                    @endif

                                                    @if(isset($products->image1))
                                                        <li >
                            
                                                            <a href="#"  class="elevatezoom-gallery active" data-update="" data-image="{{asset($products->image_path1)}}" data-zoom-image="{{asset($products->image_path1)}}">
                                                                <img src="{{asset($products->image_path1)}}" alt=""/>
                                                            </a>

                                                        </li>
                                                     @else 
                                                        {{-- <li>
                                                                
                                                            <a href="#"  class="elevatezoom-gallery active" data-update="" data-image="{{asset('assets/images/logo.png')}}" data-zoom-image="{{asset('assets/images/logo.png')}}">
                                                                <img src="{{asset('assets/images/logo.png')}}" alt="ri"/>
                                                            </a>
                                                    
                                                        </li> --}}
                                                    @endif
                                                    
                                                    @if(isset($products->image2))
                                                        <li >
                                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset($products->image_path2)}}" data-zoom-image="{{asset($products->image_path2)}}">
                                                                <img src="{{asset($products->image_path2)}}" alt=""/>
                                                            </a>

                                                        </li>
                                                    @else 
                                                        {{-- <li>
                                                                
                                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset('assets/images/logo.png')}}" data-zoom-image="{{asset('assets/images/logo.png')}}">
                                                                <img src="{{asset('assets/images/logo.png')}}" alt="ri"/>
                                                            </a>
                                                    
                                                        </li> --}}
                                                    @endif

                                                    @if(isset($products->image))
                                                    <li >
                                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset($products->image_path)}}" data-zoom-image="{{asset($products->image_path)}}">
                                                            <img src="{{asset($products->image_path)}}" alt=""/>
                                                        </a>

                                                    </li>
                                                @else 
                                                    {{-- <li>
                                                            
                                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{asset('assets/images/logo.png')}}" data-zoom-image="{{asset('assets/images/logo.png')}}">
                                                            <img src="{{asset('assets/images/logo.png')}}" alt="ri"/>
                                                        </a>
                                                
                                                    </li> --}}
                                                @endif
                                            </ul>
                                            
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="product_d_right">
                                <form action="#">

                                        <h1>{{$products->title}}</h1>
                                        <div class="price_box">
                                            <span class="current_price"> Rs. {{$products->price}}</span>
                                           

                                        </div>
                                        <div class="product_desc">
                                            <p>{!! $products->description !!}</p>
                                        </div>
                                        
                                       
                                        <div class="product_meta">
                                            <span>Category: <a href="#">{{ $products->category->title}}</a></span>
                                        </div>
                                        <div class="product-form product-qty">
                                            {{-- {{-- <form action="{{ route('add-to-cart') }}" method="POST" style="width:100%"> --}}
                                                
                                             <input type="hidden" name="id" class="id" value="{{ $products->id }}">
                                                <div class="increase">
                                                    <label>QTY:</label>    
                                                    <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                                    <input type="number" id="number" value="1" name="quantity" class="quantityproduct"/>
                                                    <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                                 </div>

                                                 <div class="product-form-group">
                                                     {{-- <div class="input-group">
                                                         <button type="button" class="quantity-minus d-icon-minus"></button>
                                                         <input name="quantity" class="quantityproduct form-control" type="number" min="1" max="1000000" value="1">
                                                         <button type="button" class="quantity-plus d-icon-plus"></button>
                                                     </div> --}}
                                                    
                                                     <div class="btn-product btn-cart">
                                                             @if(!empty(Auth::guard('customer')->user()))
                                                                 <a href="javascript:;" class="btn-addtocart" data-price = {{$products->price}} data-value="{{ $products->slug }}" data-id="{{$products->id}}"><i class="d-icon-bag"></i>Add To Cart</a>
                                                             @else
                                                             <a href="{{url('/login')}}" title="Add to Cart" class="add_to_cart"><i class="d-icon-bag"></i> Add to Cart</a>
                                                             @endif
                                                    </div>
                                                    
                                                 </div>
                                            
                                         </div>
                                

                                    </form>
                                

                                </div>
                            </div>
                        </div> 
                  
                @endif 
            </div>
            <!--product details end-->

            <!--product info start-->
            <div class="product_d_info">
                <div class="row">
                    <div class="col-12">
                        <div class="product_d_inner">   
                            <div class="product_info_button">    
                                <ul class="nav" role="tablist">
                                    <li >
                                        <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                    </li>
                                    <li>
                                         <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                    <div class="product_info_content">

                                         <p>{!!$products->description!!}</p>
                                    </div>    
                                </div>
                                <div class="tab-pane fade" id="sheet" role="tabpanel" >
                                    
                                    <div class="product_info_content">

                                       <p>{!!$products->specification!!}</p>

                    

                                    </div>    
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>  
            </div>  
            <!--product info end-->
        </div>
       
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).on('click','.btn-addtocart',function(e){
       e.preventDefault();
       var qty = $('.quantityproduct').val();
       var product_id = Number($(this).data('id'));
       var id = $('.id').val();
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
               $('.cart-count').html(totalcount);

               Swal.fire(
                        'Added to cart',
                        '',
                        'success'
                    )
              
           }
       })
   });

   function increaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 1 : value;
        value++;
        document.getElementById('number').value = value;
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 1 : value;
        value < 2 ? value = 2 : '';
        value--;
        document.getElementById('number').value = value;
    }
</script>
@endpush