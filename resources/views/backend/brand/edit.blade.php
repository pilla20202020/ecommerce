@extends('backend.layouts.admin.admin')

@section('title', 'brand')

@section('content')
<section>
        <div class="section-body">
            <form class="form form-validate floating-label" action="{{route('brand.update',$brand->slug)}}"
                  method="POST" enctype="multipart/form-data" novalidate>
            @method('PUT')
            @include('backend.brand.partials.form', ['header' => 'Edit brand <span class="text-primary">('.($brand->title).')</span>'])
            </form>
        </div>
</section>
@stop

@push('scripts')
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/dropify/dropify.min.js') }}"></script>
@endpush

