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
