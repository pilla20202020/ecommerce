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
                        <li><a href="{{ route('user-register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>         
</div>
<!--breadcrumbs area end-->


<!-- customer login start -->
<div class="customer_login">
    <div class="container">
        <div class="row justify-content-center">
           <!--login area start-->
           
            <!--login area start-->

            <!--register area start-->
            <div class="col-lg-6 col-md-6 ">
                @if ($errors->any())
                        <div class="row">
                            <div class="col mb-4">
                                <div class="alert alert-danger alert-summary alert-light alert-message alert-inline">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h4 class="alert-title">Oh snap!</h4>Change a few things up and try submitting
                                    again.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn btn-link btn-close">
                                        <i class="d-icon-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                <div class="account_form register">
                    <h2>Register</h2>
                    <form action="{{ route('customer-register') }}" method="POST" >
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-name"
                                name="name" placeholder="Full Name *" value="{{ old('name') }}" required />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="register-email"
                                name="email" placeholder="Email address *" value="{{ old('email') }}" required />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="register-password"
                                name="password" placeholder="Password *" required />
                        </div>
                       
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-phone" name="phone" placeholder="Phone *" value="{{ old('phone') }}" required="">
                        </div>
                       
                        <button class="btn btn-dark btn-block btn-rounded"
                            type="submit">Register</button>
                    </form>
                </div>    
            </div>
            <!--register area end-->
        </div>
    </div>    
</div>
<!-- customer login end -->

@endsection