@extends ('frontend.layouts.app')
@section('content')
    <!-- START SECTION BREADCRUMB -->

<!-- START SECTION 404 -->
<section class="background_bg overlay_bg2 full_screen"  style="background-image: url({{asset('assets/images/404error.png')}})">
    <div class="container h-100">
        <div class="row justify-content-center align-content-center h-100">
            <div class="col-md-6 col-sm-8">
                <div class="text-center">
                    <div class="error_txt">404</div>
                    <h4 class="text_danger">oops! Product Not Found!</h4>
                    <h6>The product you were looking for could not be found.</h6>
                    <a href="{{route('homepage')}}" class="btn btn-outline-black">Back To Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION 404 -->

@endsection
