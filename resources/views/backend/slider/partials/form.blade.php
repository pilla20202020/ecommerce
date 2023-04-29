@csrf
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-form-label pt-0">Title</label>
                                    <div class="">
                                        <input class="form-control" type="text" required name="title" value="{{ old('title', isset($gallery->title) ? $gallery->title : '') }}" placeholder="Enter Title">
                                    </div>
                                    <span id="textarea1-error" class="text-danger">{{ $errors->first('title') }}</span>
                                    <label for="Name">Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-form-label pt-0">Caption</label>
                                    <div class="">
                                        <input class="form-control" type="text"  name="caption" value="{{ old('caption', isset($gallery->caption) ? $gallery->caption : '') }}" placeholder="Enter Caption">
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                             <div class="form-group">
                                <label for="" class="col-form-label pt-0">Link URL</label>
                                    <div class="">
                                        <input class="form-control" type="text"  name="link_url" value="{{ old('link_url', isset($gallery->link_url) ? $gallery->link_url : '') }}" placeholder="Enter Link URL">
                                    </div>
                            </div>
                        </div>
                    </div>
                   

                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                                <label for="" class="col-form-label pt-0">Link Caption</label>
                                    <div class="">
                                        <input class="form-control" type="text" name="link_caption" value="{{ old('link_caption', isset($gallery->link_caption) ? $gallery->link_caption : '') }}" placeholder="Enter Link Caption">
                                    </div>
                         </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label class="text-default-light">Featured Image</label>
                            @if(isset($gallery) && $gallery->image)
                                <input type="file" name="image" class="dropify" data-default-file="{{ asset($gallery->thumbnail_path) }}"/>
                            @else
                                <input type="file" name="image" class="dropify"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card card-affix affix-4">
            <div class="card-head">
                <div class="tools">
                    <a class="btn btn-default btn-ink" href="{{ route('gallery.index') }}">
                        <i class="md md-arrow-back"></i>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-actionbar">
                <div class="card-actionbar-row">
                    <button type="reset" class="btn btn-default ink-reaction">Reset</button>
                    {{--<input type="submit" name="draft" class="btn btn-info ink-reaction" value="Save Draft">--}}
                    <input type="submit" name="publish" class="btn btn-primary ink-reaction" value="{{ isset($photo) && $photo->is_published ? 'Save' : 'Publish' }}">
                </div>
            </div>
        </div>
    </div>
</div>
