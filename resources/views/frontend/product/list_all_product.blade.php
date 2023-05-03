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
                                <li><a href="javascript: void(0);">List All Products</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>



<!--breadcrumbs area end-->

    <!--shop  area start-->

    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_list widget_filter">
                            <h2>Price</h2>
                            <div class="row">
                                <div class="col-sm-12">
                                <div id="slider-range"></div>
                                </div>
                            </div>
                            <div class="row slider-labels">
                                <div class="col-xs-6 caption">
                                <strong>Min:</strong> <span id="slider-range-value1"></span>
                                </div>
                                <div class="col-xs-6 text-right caption ml-auto">
                                <strong>Max:</strong> <span id="slider-range-value2"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                <form>
                                    <input type="hidden" id="inputsliderangemin" name="min-value" value="">
                                    <input type="hidden" id="inputsliderangemax" name="max-value" value="">
                                </form>
                                </div>
                            </div>
                        </div>
                        <div class="widget_list">
                            <h2>Brand</h2>
                            @foreach ($brands as $key => $brand)
                                <div class="form-check">
                                    <input class="form-check-input" name="brandname" type="checkbox" value="{{$brand->id}}" id="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    {{$brand->title}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="widget_list">
                            <h2>Categories</h2>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" name="categoryname" type="checkbox" value="{{$category->id}}" id="">
                                    <label class="form-check-label" for="defaultCheck1">
                                    {{$category->title}}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        {{-- <div class="widget_list">
                            <h2>Stocks</h2>
                            <input type="radio" id="instock" name="stock" value="in_stock">
                            <label for="instock">In stock</label><br>
                            <input type="radio" id="outoffstock" name="stock" value="out_of_stock">
                            <label for="outoffstock">Out off Stock</label><br>
                            <hr>
                        </div> --}}
                        {{-- <button class="btn btn-sm btn-info btn-clearfilter justify-content-center">Clear Filter</button> --}}


                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <!--shop wrapper start-->
                    <!--shop toolbar start-->
                    <div class="shop_title">
                        <h1>List All Products</h1>
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

                                    <div class="dropdown d-flex">
                                        <label for="exampleFormControlSelect1 col-3">Sort By:</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option disabled selected><a href="#"> -- Select Option --</a></option>
                                            <option value="name"><a href="#">Product Name</a></option>
                                            <option value="low"><a href="#">Price: Low to High</a></option>
                                            <option value="high"><a href="#">Price: High to Low</a></option>
                                            <option value="new"><a href="#">Date Listed (New)</a></option>
                                        </select>
                                    </div>


                        </div>

                    </div>
                    <!--shop toolbar end-->

                    <div class="row mb-3 listproducts">
                        @include('Frontend.product.productrender')
                    </div>

                    {{-- @if($products)
                    <div class="row shop_wrapper">
                        @foreach($products as $productsdata)
                            <div class="col-lg-4 col-md-4 col-12 ">
                                <div class="single_product">

                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('products.detail', $productsdata->slug) }}"><img src="{{asset($productsdata->image_path)}}" alt=""></a>


                                        <div class="action_links">
                                            <ul>
                                                @if(!empty(Auth::guard('customer')->user()))
                                                    <li class="add_to_cart"><a href="javascript:;" class="addtocart" data-id="{{$productsdata->id}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                @else
                                                    <li class="add_to_cart"><a href="{{route('user-login')}}" title="add to cart"><i class="ion-bag"></i></a></li>
                                                @endif
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
                    @endif --}}

                    {{-- <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                            <ul>
                                {{$products->links()}}
                            </ul>
                        </div>
                    </div> --}}
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->

@endsection

@push('scripts')
<script>
    //  Add To Cart
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

    $(document).ready(function() {
        $("#exampleFormControlSelect1").change(function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // Brand Name
    $(document).ready(function() {
        $('input[name="brandname"]').change(function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // Category Name
    $(document).ready(function() {
        $('input[name="categoryname"]').change(function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // Stock Name
    $(document).ready(function() {
        $('input[name="stock"]').change(function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // Min Price Slider
    $(document).ready(function() {
        $('#slider-range-value1').on('change',function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // Max Price Slider
    $(document).ready(function() {
        $('#slider-range').on('mouseup',function(){
            var min = $('#slider-range-value1').html().replace(/,/g, '');
            var max = $('#slider-range-value2').html().replace(/,/g, '');
            var stock = $('input[name="stock"]:checked').val();
            var filter = $('#exampleFormControlSelect1 option:selected').val();
            // brand
            var brand = [];
            var incr=0;
            $('input[name="brandname"]:checked').each(function() {
                if (this.checked) {
                    brand[incr]=(this.value);
                    incr++;
                }
            });
            // brand

            // category
            var category = [];
            var i=0;
            $('input[name="categoryname"]:checked').each(function() {
                if (this.checked) {
                    category[i]=(this.value);
                    i++;
                }
            });
            // category

            $.ajax({
                type: 'get',
                url: "{{ route('applyfilter') }}",
                data: {
                    category: category,
                    brand: brand,
                    min: min,
                    max: max,
                    stock: stock,
                    filter: filter,
                },
                success:function(data){
                    $('.listproducts').html(data);
                }
            })
        });
    });

    // $(document).on('click','.btn-clearfilter',function() {
    //     alert('ere');
    //     $('input:checkbox').removeAttr('checked');
    //     document.getElementsByName('min-value').value = moneyFormat.from(
    //     100000[0]);
    // })
</script>

@endpush
