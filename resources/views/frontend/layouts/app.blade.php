<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.hasthemes.com/alista-preview/alista/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:04:03 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ecommerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- CSS
    ========================= -->

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} ">

</head>

<body>

@include('frontend.layouts.partials.header')
@include('sweetalert::alert')


     @yield('content')


    @include('frontend.layouts.partials.footer')




<!-- JS
============================================ -->

<!-- Plugins JS -->
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://kit.fontawesome.com/746caa9b5e.js" crossorigin="anonymous"></script>

<script>
    $('.view-quickview').click(function(e){
        e.preventDefault();
        let product_id = $(this).data('product_id');
        $.ajax({
            url: "{{route('quick-view-product')}}",
            type: "post",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: product_id
            },
            success:function(response){
                if(typeof(response) != 'object'){
                    response = JSON.parse(response)
                }
                if(response.status){
                    $('#pro-1').html('<img src="uploads/product/'+response.data.image+'" id="viewproductimage" alt="">');
                    $('#productheading').text(response.data.title);
                    $('#productprice').text('Rs. '.concat((response.data.price)));
                    $('#productdescription').text(response.data.description.replace('<p>','').replace('</p>', ''));
                    $('#productquickview').modal('show');
                }
            }
        });
    });


    $(document).ready(function() {
        var getcurrentactive = $('.getcurrentactive').closest('.mega_items').children().addClass('active');
        console.log(getcurrentactive);
    });
</script>

@stack('scripts')
</body>


<!-- Mirrored from demo.hasthemes.com/alista-preview/alista/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:04:03 GMT -->
</html>
