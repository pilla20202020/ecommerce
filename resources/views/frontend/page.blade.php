@extends ('frontend.layouts.app')
@section('content')
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="assets/images/about_bg.jpg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h1>{{$page->title}}</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$page->title}}</a></li>
                </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

    <!-- START SECTION TEACHER -->
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="single_event">
                        @if($page->image)
                            <div class="content_img">
                                <img src="{{asset($page->image_path)}}" alt="{{$page->title}}">
                            </div>
                        @endif
                        <div class="event_title">
                            <div class="row align-items-end">
                            </div>
                        </div>
                        <div class="entry_content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION TEACHER -->
@endsection
