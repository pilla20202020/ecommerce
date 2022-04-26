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
                        <li><a href="{{ route('services') }}">Our Services</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>         
</div>
<!--breadcrumbs area end-->

<!--services img area-->
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
 <!--services img end-->

 @endsection