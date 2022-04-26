@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-body">
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="number" name="offer_price" class="form-control" required
                                       value="{{ old('title', isset($deal->offer_price) ? $deal->offer_price : '') }}"/>

                                <label for="name">Offer Price</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                    <select name="product_id" class="form-control" id="">
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}" @if(isset($product)) @if($product->id == $product->id) selected @endif @endif>{{$product->title}}</option>
                                            @endforeach
                                    </select>
                                    <span id="textarea1-error" class="text-danger">{{ $errors->first('$deal->album_id') }}</span>
                                    <label for="Name">Select Product</label>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="" data-spy="affix" data-offset-top="50">
            <div class="panel-group" id="accordion1">
                <div class="card panel expanded">
                    <div class="card-head" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1">
                        <header>Publish</header>
                        <div class="tools">
                            <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                        </div>
                    </div>
                    <div id="accordion1-1" class="collapse in">
                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <a class="btn btn-default btn-ink" href="{{ route('deal.index') }}">
                                    <i class="md md-arrow-back"></i>
                                    Back
                                </a>
                                <input type="submit" name="pageSubmit" class="btn btn-info ink-reaction" value="Save">
                            </div>
                        </div>
                        <div class="card-head">

                            <div class="side-label">
                                <div class="label-head">
                                    <span>Featured</span>
                                </div>
                                <div class="label-body">
                                    <input type="checkbox" id="switch_demo_1" name="is_featured"
                                           {{ old('is_featured', isset($deal->is_featured) ? $deal->is_featured : '')=='1' ? 'checked':'' }} data-switchery/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end .panel --><!--end .panel --><!--end .panel --><!--end .panel -->
                {{--            </div><!--end .panel-group -->--}}
                {{--        <div class="panel-group" id="accordion1">--}}

                <!--end .panel --><!--end .panel --><!--end .panel --><!--end .panel -->
            </div><!--end .panel-group -->
        </div>
    </div>
</div>
