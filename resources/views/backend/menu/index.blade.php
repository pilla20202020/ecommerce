@extends('backend.layouts.admin.admin')

@section('title', 'Menu')

@push('styles')

    <style>
        #menu-accordion .card-head {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')


    {{-- For New backend menu bar --}}
    <section>
        <div class="section-body">
            <div class="row">

                {{ Form::open(['route' => 'menu.update', 'files' => true, 'method' => 'put', 'class' => 'form form-validation', 'novalidate']) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="first2">
                        <div class="col-md-8 col-md-offset-2">
                            <article class="margin-bottom-xxl">
                                <button class="btn btn-primary ink-reaction" data-toggle="modal" data-target="#addMenu"
                                        type="button">
                                    <i class="md md-add"></i>
                                    Add
                                </button>
                                <button class="btn btn-primary ink-reaction" type="submit">
                                    <i class="md md-save"></i>
                                    Save
                                </button>
                            </article>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel-group" id="menu-accordion" data-sortable="true">
                                @foreach($menus as $key => $menu)
                                    <div class="card panel {{ session('collapse_in') == $menu->slug ? 'expanded' : '' }}"
                                         id="{{ $menu->id }}">
                                        <input type="hidden" name="order[]" value="{{ $menu->id }}">
                                        <div class="card-head collapsed {{ session('collapse_in') == $menu->slug ? '' : 'collapsed' }}"
                                             data-toggle="collapse"
                                             data-parent="#menu-accordion"
                                             data-target="#menu-accordion-{{ $key }}">
                                            <header>{{ $menu->name }}</header>
                                            <div class="tools">
                                                <button type="button" class="btn btn-icon-toggle btn-add-sub-menu"
                                                        data-url="{{ route('menu.subMenu.component.modal', $menu->id) }}"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Add Sub Menu"
                                                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                                                    <i class="md md-add"></i>
                                                </button>
                                                @unless($menu->is_primary)
                                                    <a class="btn btn-icon-toggle btn-delete" style="color: #f44336;"
                                                       data-url="{{ route('menu.destroy', $menu->id) }}">
                                                        <i class="md md-delete"></i>
                                                    </a>
                                                    {{-- <a href="{{ route('menu.destroy', $menu->id) }}">
                                                        <button type="button"
                                                            class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </button> --}}
                                                @endunless
                                                <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                            </div>
                                        </div>
                                        <div id="menu-accordion-{{ $key }}"
                                             class="collapse {{ session('collapse_in') == $menu->slug ? 'collapse in' : 'collapse' }}">
                                            <div class="card-body">
                                                <div class="panel-group" id="menu-accordion-{{ $key }}"
                                                     data-sortable="true">
                                                    @foreach($menu->subMenus->sortBy('order') as $subKey => $subMenu)
                                                        <div class="card panel subpanel {{ session('collapse_in') == $subMenu->slug ? 'expanded' : '' }}"
                                                             id="{{ $subMenu->id }}">
                                                            <input type="hidden"
                                                                   name="sub_menu_order[{{ $menu->slug }}][]"
                                                                   value="{{ $subMenu->id }}">
                                                            <div class="card-head collapsed {{ session('collapse_in') == $subMenu->slug ? '' : 'collapsed' }}"
                                                                 data-toggle="collapse"
                                                                 data-parent="#menu-accordion-{{ $key }}"
                                                                 data-target="#submenu-accordion-{{ $subMenu->slug}}{{ $subKey }}" style="background: #E5E6E6">
                                                                <header>{{ $subMenu->name }}</header>
                                                                <div class="tools">
                                                                    <button type="button"
                                                                            class="btn-icon-toggle btn-add-sub-menu"
                                                                            data-url="{{ route('menu.subMenu.childsubMenu.component.childmodal', $subMenu->id) }}"
                                                                            data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            data-original-title="Add Child Sub Menu"
                                                                            data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                                                                        <i class="md md-add"></i>
                                                                    </button>
                                                                    @unless($subMenu->is_primary)
                                                                        <a class="btn btn-icon-toggle btn-delete" style="color: #f44336;"
                                                                           data-url="{{ route('menu.subMenu.destroy', [$menu->id, $subMenu->id]) }}">
                                                                            <i class="md md-delete"></i>
                                                                        </a>
                                                                    @endunless
                                                                    <a class="btn btn-icon-toggle"><i
                                                                            class="fa fa-angle-down"></i></a>
                                                                </div>
                                                            </div>
                                                            <div id="submenu-accordion-{{ $subMenu->slug}}{{ $subKey }}"
                                                                 class="collapse {{ session('collapse_in') == $menu->slug ? 'collapse in' : 'collapse' }}">
                                                                <div class="card-body">
                                                                    <div class="panel-group"
                                                                         id="submenu-accordion-{{ $subKey }}"
                                                                         data-sortable="true">
                                                                        @foreach($subMenu->childsubMenus->sortBy('order') as $childSubKey => $childsubMenu)
                                                                            <div class="card panel childsubpanel {{ session('collapse_in') == $childsubMenu->slug ? 'expanded' : '' }}"
                                                                                 id="{{ $childsubMenu->id }}">
                                                                                <input type="hidden"
                                                                                       name="child_sub_menu_order[{{ $subMenu->slug }}][]"
                                                                                       value="{{ $childsubMenu->id }}">
                                                                                <div class="card-head collapsed {{ session('collapse_in') == $childsubMenu->slug ? '' : 'collapsed' }}"
                                                                                     data-toggle="collapse"
                                                                                     data-parent="#submenu-accordion-{{ $subKey }}"
                                                                                     data-target="#childsubmenu-accordion-{{ $childSubKey }}">
                                                                                    <header>{{ $childsubMenu->name }}</header>
                                                                                    <div class="tools">
                                                                                        @unless($childsubMenu->is_primary)
                                                                                            <a class="btn btn-icon-toggle btn-delete" style="color: #f44336;"
                                                                                               data-url="{{ route('menu.subMenu.childsubMenu.destroy', [$menu->id, $subMenu->id, $childsubMenu->id]) }}">
                                                                                                <i class="md md-delete"></i>
                                                                                            </a>
                                                                                        @endunless
                                                                                    </div>
                                                                                </div>
                                                                            </div><!--end .panel -->
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end .panel -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .panel -->
                                @endforeach
                            </div><!--end .panel-group -->
                        </div><!--end .col -->
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </section>

    <div id="subMenuModal"></div>

    <div class="modal fade" id="addMenu" tabindex="-1" role="dialog" aria-labelledby="addMenuLabel">
        {{ Form::open(['route' => 'menu.store', 'class' => 'form']) }}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addMenuLabel">Add Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
{{--                        {{ Form::select('page', $pages, null, ['class' => 'form-control select2', 'placeholder' => 'Select a page or leave blank (#)']) }}--}}
                        <select class="form-control select2" name="page">
                            <option value ="">Select a page or leave blank (#)</option>
                            @foreach($pages as $page)
                                <option value="{{$page->slug}}">{{$page->title}}</option>
                            @endforeach
                        </select>
                        <label class="page">Page</label>
                    </div>
                    <div class="form-group">
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '(same as page title)']) }}
                        <label class="name">Name</label>
                    </div>

                    <div class="form-group">
                        {{ Form::text('custom_url', old('custom_url'), ['class' => 'form-control', 'placeholder' => '(enter your custom URL here..)']) }}
                        <label class="name">Custom URL</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary">Add Menu</button>
                </div>
            </div>
        </div>
        {{Form::close() }}
    </div>
@stop

@push('scripts')
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/libs/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.nestable-list').nestable();
            $(".btn-add-sub-menu").on("click", function (e) {
                e.stopPropagation();
                var $button = $(this);
                $.ajax({
                    "type": "GET",
                    "url": $button.data("url"),
                    "beforeSend": function () {
                        $button.button('loading');
                    },
                    "complete": function () {
                        $button.button('reset');
                    },
                    "success": function (response) {
                        $("#subMenuModal").html(response);
                        $(document).find("#addSubMenu").modal();
                    },
                    "error": function () {
                        bootbox.alert("Error fetching modal!");
                    }
                });
            });
            $(".btn-delete").on("click", function (e) {
                e.stopPropagation();
                var $button = $(this);
                bootbox.confirm("Are you sure?", function (response) {
                    if (response)
                        $.ajax({
                            "type": "POST",
                            "url": $button.data("url"),
                            "data": {"_method": "GET"},
                            "success": function (response) {
                                if (response.Menu) {
                                    $button.closest(".panel").detach();
                                } else if (response.SubMenu) {
                                    $button.closest(".subpanel").detach();
                                } else if (response.ChildSubMenu) {
                                    $button.closest(".childsubpanel").detach();
                                }
                                else {
                                    $button.closest(".dd-item").detach();
                                }
                            },
                            "error": function () {
                                bootbox.alert("Error deleting menu!");
                            }
                        });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $(".select2").select2({
                selectOnClose: true,
                closeOnSelect: false,
            });

            $(".M").select2({
                selectOnClose: true,
                closeOnSelect: false,
            });
        });
    </script>
@endpush
