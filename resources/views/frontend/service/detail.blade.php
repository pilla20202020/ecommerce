@extends ('frontend.layouts.app')
@section('content')




<!--training body area start-->
<div class="main_blog_area blog_details">
    <div class="container">
        <div class="row">
            @if($trainings)
                <div class="col-lg-9 col-md-12">
                    <!--blog grid area start-->
                    <div class="blog_details_wrapper">
                       
                        <div class="single_blog">
                            <div class="blog_title">
                                <h2><a href="#">{{$trainings->title}}</a></h2>
                                <div class="blog_post">
                                    <ul>
                                        <li class="post_author">Trainer : {{$trainings->trainer}}</li>
                                        <li class="post_date">{{$trainings->training_date->format('d/m/Y')}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="blog_thumb">
                            <a href="#"><img src="{{asset($trainings->image_path)}}" alt=""></a>
                        </div>
                            <div class="blog_content">
                                <div class="post_content">
                                    <p>{!!$trainings->content!!}</p>
                                    
                                </div>

                            </div>
                        </div>
                        
                        
                    </div>
                    <!--blog grid area start-->
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="blog_sidebar_widget">
                        <div class="widget_list widget_categories">
                            <h2>Our Services</h2>
                           
                            <ul>
                                @foreach($services as $service)
                                <li>
                                    {{$service->title}}
                                </li>
                                @endforeach
                               
                            </ul>
                        </div>
                    
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!--training section area end-->

@endsection

