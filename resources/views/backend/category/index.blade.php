@extends('backend.layouts.admin.admin')

@section('title', 'Category')

@section('content')
    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <header class="text-capitalize">Category</header>
                    <div class="tools">
                        <a class="btn btn-primary ink-reaction" href="{{ route(substr(Route::currentRouteName(), 0 , strpos(Route::currentRouteName(), '.')) . '.create') }}">
                            <i class="md md-add"></i>
                            Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-hover display">
                        <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th width="20%">Image</th>
                            <th width="20%" class="text-center">Title</th>
                            <th width="40%">Description</th>
                            <th width="15%" class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @each('backend.category.partials.table', $categories, 'category')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@push('styles')
    <style type="text/css">
        #accordion .card-head {
            cursor: n-resize;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        function readURL(input) {
            var imgId = $(input).data("id");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var $image = $("#category--" + imgId);
                    if ($image.closest("form").valid()) {
                        $image.attr("src", e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function () {
            $(".file").change(function () {
                readURL(this);
            });
        });

        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endpush
