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
                        <li><a href="{{ route('contact') }}">contact us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>         
</div>
<!--breadcrumbs area end-->

<div class="home_contact_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="text-center animation animated fadeInUp" data-animation="fadeInUp" data-animation-delay="0.01s" style="animation-delay: 0.01s; opacity: 1;">
                    <div class="heading_s1 text-center">
                        <h2>Get In Touch</h2>
                    </div>
                    <div class="small_divider"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="box_shadow1 radius_all_10">
                    <div class="row no-gutters">
                        <div class="col-md-6 animation animated fadeInLeft" data-animation="fadeInLeft" data-animation-delay="0.02s" style="animation-delay: 0.02s; opacity: 1;">
                            @if(Illuminate\Support\Facades\Session::has('success'))
                                <div class="alert alert-success">
                                    {{Illuminate\Support\Facades\Session::get('success')}}
                                </div>
                            @endif
                            <div class="padding_eight_all">
                                <div class="field_form">
                                    <form method="post" name="enq" action="{{route('send-contact')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <input required="required" placeholder="Enter Name" id="first-name" class="form-control" name="name" type="text">
                                            </div>
                                            <div class="form-group col-12">
                                                <input required="required" placeholder="Enter Email" id="email" class="form-control" name="email" type="email">
                                            </div>
                                            <div class="form-group col-12">
                                                <input required="required" placeholder="Enter Subject" id="subject" class="form-control" name="subject" type="text">
                                            </div>
                                         
                                            <div class="form-group col-lg-12">
                                                <textarea required="required" placeholder="Message" id="description" class="form-control" name="message" rows="3"></textarea>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit" title="Submit Your Message!" class="btn btn-default" name="submit" value="Submit">Submit</button>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <div id="alert-msg" class="alert-msg text-center"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 animation animated fadeInRight" data-animation="fadeInRight" data-animation-delay="0.4s" style="animation-delay: 0.4s; opacity: 1;">
                            <div class="contact_map map_radius_rtrb overflow-hidden h-100">
                                <!-- <iframe src="{{setting('google_map')}}" allowfullscreen=""></iframe> -->
                                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d56529.64363409014!2d85.3163051184924!3d27.68321969714603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x39eb19b1923a15c3%3A0x8fab2e10d8482402!2saccessworld!3m2!1d27.6794199!2d85.3196747!5e0!3m2!1sen!2snp!4v1618810226314!5m2!1sen!2snp" width="600" height="450" style="border:0;margin-left:20px" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection