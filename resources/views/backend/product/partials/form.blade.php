@csrf

@push('styles')
    <link href="{{ asset('backend/assets/css/theme-default/libs/wizard/wizard.css?1425466601') }}" rel="stylesheet">
@endpush


    <div class="section-body contain-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body ">
                        <div id="rootwizard1" class="form-wizard form-wizard-horizontal">
                                <div class="form-wizard-nav">
                                    <div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
                                    <ul class="nav nav-justified">
                                        <li class="active"><a href="#tab1" data-toggle="tab"><span class="step">1</span> <span class="title">Overview</span></a></li>
                                        <li><a href="#tab2" data-toggle="tab"><span class="step">2</span> <span class="title">Gallery</span></a></li>

                                    </ul>
                                </div><!--end .form-wizard-nav -->
                                <div class="tab-content clearfix">


                                    <div class="tab-pane active" id="tab1">
                                        <br/><br/>
                                        <div class="form-group">
                                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', isset($product->title) ? $product->title : '') }}">
                                            <label for="title" class="control-label">Title</label>
                                            <span id="textarea1-error" class="text-danger">{{ $errors->first('title') }}</span>

                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="category_id" class="form-control category_id" required>
                                                    <option value="">Select category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" @if(isset($category_search)) @if($category_search->id == $category->id) selected @endif @endif>{{$category->title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="textarea1-error" class="text-danger">{{ $errors->first('category_id') }}</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="subcategory_id" class="form-control subcategory_class" >
                                                    <option value="">Select Sub Category</option>
                                                    @if(isset($category_search))
                                                    @foreach($subcategories as $subcategory)
                                                        <option value="{{$subcategory->id}}" @if(isset($subcategory_search)) @if($subcategory_search->id == $subcategory->id) selected @endif @endif>{{$subcategory->title}}</option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                                <span id="textarea1-error" class="text-danger">{{ $errors->first('subcategory_id') }}</span>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="brand_id" class="form-control" required>
                                                    <option value="">Select Brands</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->id}}" @if(isset($brand_search)) @if($brand_search->id == $brand->id) selected @endif @endif>{{$brand->title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="textarea1-error" class="text-danger">{{ $errors->first('brand_id') }}</span>
                                            </div>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <strong>Description</strong>
                                                    <textarea name="description" id="" class="ckeditor">{{old('description',isset($product->description)?$product->description : '')}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                        </div>


                                        <div class="row mt-5">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <strong>Specification</strong>
                                                    <textarea name="specification" id="" class="ckeditor">{{old('specification',isset($product->specification)?$product->specification : '')}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="number" name="price" class="form-control" required value="{{ old('price', isset($product->price) ? $product->price : '') }}"/>
                                                    <label for="price" class="control-label">Price</label>
                                                </div>
                                            </div>




                                            <div class="col-md-6">
                                                <label for="Name">Keywords - Use (enter) for multiple</label>
                                                <select name="keywords[]" class="form-control offerd_course" multiple>
                                                    @if(isset($keywords) )
                                                        @foreach ($keywords as $keyword)
                                                            <option value="{{$keyword}}" selected>{{$keyword}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="text-danger">{{ $errors->has('keywords') ? $errors->first('keywords') : '' }} </span>
                                            </div>



                                        </div>

                                        <div class="row">
                                            <div class="col-md-6" style="display:inline-flex">
                                                <label for="price" style="padding-top: 15px;padding-right: 20px;" class="control-label">Stock:</label>
                                                <input type="radio" id="instock" name="stock" value="in_stock" @if(isset($product) && $product->stock == "in_stock") checked @endif>
                                                <label for="instock" class="pt-2" style="padding-top: 15px;padding-right: 20px; padding-left: 5px">In stock</label><br>
                                                <input type="radio" id="outoffstock" name="stock" value="out_of_stock" @if(isset($product) && $product->stock == "out_of_stock") checked @endif >
                                                <label for="outoffstock" style="padding-top: 15px;padding-right: 20px; padding-left: 5px">Out off Stock</label><br>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="is_featured" class="control-label">Featured</label>
                                                <div class="form-group">
                                                    <input type="checkbox" id="switch_demo_1" name="is_featured"
                                                        {{ old('is_featured', isset($product->is_featured) ? $product->is_featured : '')=='1' ? 'checked':'' }} data-switchery/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="is_trending" class="control-label">Trending</label>
                                                <div class="form-group">
                                                    <input type="checkbox" id="switch_demo_1" name="is_trending"
                                                        {{ old('is_trending', isset($product->is_trending) ? $product->is_trending : '')=='1' ? 'checked':'' }} data-switchery/>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="status" class="control-label">Best Seller</label>
                                                <div class="form-group">
                                                    <input type="checkbox" id="switch_demo_1" name="best_seller"
                                                        {{ old('best_seller', isset($product->best_seller) ? $product->best_seller : '')=='1' ? 'checked':'' }} data-switchery/>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="pager wizard">
                                            <li class="previous first"><a class="btn-raised" href="javascript:void(0);">First</a></li>
                                            <li class="previous"><a class="btn-raised" href="javascript:void(0);">Previous</a></li>
                                            <li class="next last"><a class="btn-raised" href="javascript:void(0);">Last</a></li>
                                            <li class="next"><a class="btn-raised" href="javascript:void(0);">Next</a></li>
                                        </ul>
                                    </div>
                                    <!--end #tab1 -->



                                    @include('backend.product.partials.gallery-tab')
                                    <!--end #tab2 -->


                                </div><!--end .tab-content -->
                                {{-- <ul class="pager wizard">
                                    <li class="previous first"><a class="btn-raised" href="javascript:void(0);">First</a></li>
                                    <li class="previous"><a class="btn-raised" href="javascript:void(0);">Previous</a></li>
                                    <li class="next last"><a class="btn-raised" href="javascript:void(0);">Last</a></li>
                                    <li class="next"><a class="btn-raised" href="javascript:void(0);">Next</a></li>
                                </ul> --}}
                        </div><!--end #rootwizard -->
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
        </div>
    </div>


@push('scripts')
    <script src="{{ asset('backend/assets/js/libs/wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/demo/DemoFormWizard.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });

        $('.offerd_course').select2({
            tags: true
        });



        $('.category_id').change(function(e){
            e.preventDefault();
            var category_id = $(this).val();
            var body;
            $.ajax({
                type: 'POST',
                url: '{{route('product.productcategoryajax')}}',
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    category_id: category_id,
                },
                success:function(response){
                    if(typeof(response) != "object"){
                        response = JSON.parse(response);
                    }
                    console.log(response.data);
                    if(response.data){
                        $.each(response.data, function(key, subcategory){
                            console.log(subcategory);
                            body += "<option value='"+subcategory['id']+"'>"+subcategory['title']+"</option>";
                        });
                        $('.subcategory_class').html(body);
                    }
                }
            })

        })



        $(document).on('click', '#additemrow', function () {
            var b=parseFloat($("#temp").val());
            b=b+1;
            $("#temp").val(b);
            var temp=$("#temp").val();
            var tst=$('<div class="row">' +
                '<div class="col-md-4">' +
                '<input class="form-control" name="day[]" type="text" placeholder="Day">' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input class="form-control" name="itinerary_title[]" type="text" placeholder="Itinerary Title">' +
                '</div>' +
                '<div class="col-md-1" style="margin-top: 45px">' +
                '<input id="additemrow" type="button" class="btn btn-primary mr-1" value="Add Row">' +
                '</div>' +
                '<div class="col-md-1" style="margin-top: 45px">' +
                '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="remove_product(this)"><i class="fa fa-trash" ></i></a>' +
                '</div>' +
                '<div class="col-md-12" style="margin-top: 20px">' +
                '<p>Description</p>' +
                '<textarea name="itinerary_description[]" id="ckeditor" class="ckeditor form-control">{{old("itinerary_description",isset($product->itinerary_description)?$product->itinerary_description : "")}}</textarea>' +
                '</div>' +
                '</div>'
            );
            $('#additernary').append(tst);
            selectRefresh();
        });


        function remove_product(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
        function remove_productforedit(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
    </script>
@endpush
