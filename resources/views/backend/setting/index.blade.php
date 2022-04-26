@extends('backend.layouts.admin.admin')

@section('title', 'Setting')

@section('content')
    <section>
        {{ Form::open(['route'=>'setting.update','class'=>'form form-validate','method'=>'PUT','files'=>true,'novalidate']) }}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-head">
                        <header>General Settings</header>
                        <div class="tools">
                            <input type="submit" class="btn btn-primary" value="Save All">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-head">
                                    <header>General</header>
                                </div>
                                <div class="card-body tab-content">
                                    <div class="tab-pane active" id="first2">

                                        <div class="form-group">
                                            {{ Form::text('setting[name]', old('setting.name') ?: setting('name'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[name]', 'Site Title') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('setting[shipping_charge]', old('setting.shipping_charge') ?: setting('shipping_charge'), ['class'=>'form-control']) }}
                                            {{ Form::label('setting[shipping_charge]', 'Shipping_charge') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::textarea('setting[address]', old('setting.address') ?: setting('address'), ['class'=>'form-control','rows'=>2,'required']) }}
                                            {{ Form::label('setting[address]', 'Address') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::textarea('setting[google_map]', old('setting.google_map') ?: setting('google_map'), ['class'=>'form-control','rows'=>2,'required']) }}
                                            {{ Form::label('setting[google_map]', 'Google Map Link') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::textarea('setting[readmission_date]', old('setting.readmission_date') ?: setting('readmission_date'), ['class'=>'form-control','rows'=>2,'required']) }}
                                            {{ Form::label('setting[readmission_date]', 'Re-Admission Date') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-head">
                                    <header>Contacts</header>
                                </div>
                                <div class="card-body tab-content">
                                    <div class="tab-pane active" id="first3">
                                        <div class="form-group">
                                            {{ Form::text('setting[phone]', old('setting.phone') ?: setting('phone'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[phone]', 'Phone') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('setting[email]', old('setting.email') ?: setting('email'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[email]', 'email') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('setting[notification-emails]', old('setting.notification-emails') ?: setting('notification-emails'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[notification-emails]', 'notification-emails') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('setting[postbox]', old('setting.postbox') ?: setting('postbox'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[postbox]', 'postbox') }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::text('setting[placeholder]', old('setting.placeholder') ?: setting('placeholder'), ['class'=>'form-control','required']) }}
                                            {{ Form::label('setting[placeholder]', 'placeholder') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-head">
                                    <header>Social Links</header>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        {{ Form::textarea('setting[facebook]', old('setting.facebook') ?: setting('facebook'), ['class'=>'form-control','rows'=>2,'required']) }}
                                        {{ Form::label('setting[facebook]', 'Facebook') }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::textarea('setting[instagram]', old('setting.instagram') ?: setting('instagram'), ['class'=>'form-control','rows'=>2,'required']) }}
                                        {{ Form::label('setting[instagram]', 'Instagram') }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::textarea('setting[twitter]', old('setting.twitter') ?: setting('twitter'), ['class'=>'form-control','rows'=>2,'required']) }}
                                        {{ Form::label('setting[twitter]', 'Twitter') }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::textarea('setting[youtube]', old('setting.youtube') ?: setting('youtube'), ['class'=>'form-control','rows'=>2,'required']) }}
                                        {{ Form::label('setting[youtube]', 'Youtube') }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::textarea('setting[linkedin]', old('setting.linkedin') ?: setting('linkedin'), ['class'=>'form-control','rows'=>2,'required']) }}
                                        {{ Form::label('setting[linkedin]', 'LinkedIn') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
        {{ Form::close() }}
    </section>
@stop

@push('styles')
    <link href="{{ asset('css/libs/dropify/dropify.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/libs/dropify/dropify.min.js') }}"></script>
@endpush
