{{ Form::open(['route' => ['menu.subMenu.childsubMenu.store', $subMenu->id], 'class' => 'form']) }}
<div class="modal fade" id="addSubMenu" tabindex="-1" role="dialog" aria-labelledby="addChildSubMenuLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addChildSubMenuLabel">Add Child Sub Menu ({{ $subMenu->name }})</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
{{--                    {{ Form::select('page', $pages, null, ['class' => 'form-control select2', 'placeholder' => 'Select a page or leave blank (#)']) }}--}}
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Child Sub Menu</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
