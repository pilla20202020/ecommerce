@extends('backend.layouts.admin.admin')

@section('title', 'gallery')

@section('content')
<section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('gallery.store')}}" method="POST" enctype="multipart/form-data" novalidate>
            @include('backend.gallery.partials.form',['header' => 'Create a gallery'])
            </form>
        </div>
    </section>
@stop

@push('scripts')
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/dropify/dropify.min.js') }}"></script>
@endpush

