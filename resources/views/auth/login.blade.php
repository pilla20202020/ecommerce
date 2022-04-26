@extends('backend.layouts.admin.admin')

@section('Sonata', 'Login')

@section('guest')
    <!-- BEGIN LOGIN SECTION -->
    <section class="section-account">
        <div class="row col-md-12 logo" align="center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="100">
        </div>
        <div class="row col-md-12" align="center">
            <div class="card col-sm-4 col-sm-offset-4 ">
                <div class="card-body">
                    <br/>
                    <span class="text-lg text-bold text-primary" style="color: #6E2B86;">{{ ('SONATA ADMIN PANEL') }}</span>
                    <br/><br/>

                    <form class="form form-validate" role="form" style="text-align:left;" method="POST"
                          action="{{ url('/login') }}" autocomplete="off" novalidate>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="email"
                                   class="text col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            {{--<div class="col-md-6">--}}
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" style="height: 57px"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                            {{--</div>--}}
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control" style="height: 57px" id="email" name="email"--}}
                        {{--value="{{ old('email') }}" required>--}}
                        {{--<label for="login">Email</label>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <input type="password" class="form-control" style="height: 57px" id="password"
                                   name="password" required>
                            <label for="password">Password</label>
                            <p class="help-block">
                                <a href="{{ url('/password/reset') }}" target="_blank">Forgot?</a>
                            </p>
                        </div>
                        <br/>

                        <div class="form-group row">
                            {{--<div class="form-group row">--}}
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            {{--</div>--}}


                            {{--<div class="col-xs-6 text-left">--}}
                            {{--<div class="checkbox checkbox-inline checkbox-styled">--}}
                            {{--<label>--}}
                            {{--<span>Remember me</span>--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div><!--end .col -->--}}
                            <div class="col-xs-6 text-right">
                                <button class="btn btn-primary btn-raised" type="submit" style="background-color: #28A575;
    border-color: #28A575;">Login</button>
                            </div><!--end .col -->
                        </div><!--end .row -->
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- END LOGIN SECTION -->

    <footer class="text-center">
        <p>
            Copyright &#183; {{ str_replace('_',' ',config('app.name'))}} &#183; {{date('Y')}}
        </p>
    </footer>
@endsection

@push('styles')
    <style type="text/css">
        .logo {
            margin-top: 60px;
            margin-bottom: 15px;
        }
    </style>
@endpush
<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
