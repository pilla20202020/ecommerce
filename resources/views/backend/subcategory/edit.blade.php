@extends('backend.layouts.admin.admin')

@section('title', 'Subcategory')

@section('content')
    <section>
    <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('subcategory.update',$subcategory->slug)}}"
                  method="POST" enctype="multipart/form-data" novalidate>
            @method('PUT')
            @include('backend.subcategory.partials.form', ['header' => 'Edit Subcategory <span class="text-primary">('.($subcategory->title).')</span>'])
            </form>
        </div>
    </section>
@stop

@push('styles')
    <link href="{{ asset('backend/css/libs/dropify/dropify.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/js/libs/dropify/dropify.min.js') }}"></script>
@endpush
