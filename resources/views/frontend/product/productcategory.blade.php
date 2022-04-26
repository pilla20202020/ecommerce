@extends ('frontend.layouts.app')
@section('content')

  
  <!--breadcrumbs area start-->
    @if($category)
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
               
                    <div class="col-12">
                        <div class="breadcrumb_content">
                            <h3>Products</h3>
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('products',$category->slug) }}">{{$category->title}}</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>         
    </div>
    @endif
   
    
<!--breadcrumbs area end-->

    <!--shop  area start-->
    @if($category)
        <div class="shop_area shop_reverse">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!--shop wrapper start-->
                        <!--shop toolbar start-->
                        <div class="shop_title">
                            <h1>{{$category->title}}</h1>
                        </div>
                    
                        <div class="shop_toolbar_wrapper">
                            <div class="shop_toolbar_btn">

                                <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>

                                <button data-role="grid_list" type="button"  class="btn-list" data-toggle="tooltip" title="List"></button>
                            </div>
                            <div>

                                {{-- <label>Sort by :</label>
                                        <select id="sortby">
                                            <option value="" disabled selected> Default</option>
                                            <option value="name" class="sortby"> Name</option>
                                            <option value="lowtohigh" class="sortby"> Price: Low to High</option>
                                            <option value="hightolow" class="sortby"> Price: High to low</option>
                                           
                                        </select> --}}
                                        
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                Sort by 
                                            </button>
                                            <div class="dropdown-menu">
                                              <a class="dropdown-item" href="{{route('products',$category->slug)}}?option=name">Name</a>
                                              <a class="dropdown-item" href="{{route('products',$category->slug)}}?option=price-low-to-high">Price: Low to High</a>
                                              <a class="dropdown-item" href="{{route('products',$category->slug)}}?option=price-high-to-low">Price: High to low</a>
                                            </div>
                                        </div>


                            </div>
                            <div class="page_amount">
                                <p>Showing 1–9 of {{$product->count()}}</p>
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
                                            
                                           
                                            {{-- <div class="action_links">
                                                <ul>
                                                   
                                                    <li ><a href="#" class="view-quickview" data-product_id="{{$productsdata->id}}" id="quickviewproduct" data-toggle="modal" data-target="#productquickview" title="Quick View"><i class="ion-eye"></i></a></li>
                                                </ul>
                                            </div> --}}
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

                        <div class="shop_toolbar t_bottom">
                            <div class="pagination">
                                <ul>
                                   {{$product->links()}}
                                </ul>
                            </div>
                        </div>
                        <!--shop toolbar end-->
                        <!--shop wrapper end-->
                    </div>
                </div>
            </div>
        </div>
    @endif   
    <!--shop  area end-->

@endsection