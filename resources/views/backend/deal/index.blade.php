@extends('backend.layouts.admin.admin')

@section('title', 'Deals')

@section('content')
    {{-- For New backend menu bar --}}

    <section>
        <div class="section-body">
            <div class="card">
                <div class="card-head">
                    <header class="text-capitalize">Deals</header>
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
                            <th width="30%">Product</th>
                            <th width="20%">Offer Price</th>
                            <th width="20%" class="text-center">Featured</th>
                            <th width="15%" class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @each('backend.deal.partials.table', $deals, 'deal')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop
