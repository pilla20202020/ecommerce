<div class="tab-pane" id="tab2">
    <br/><br/>
    <div class="row">
        <div class="col-sm-6">
            <label class="text-default-light">Featured Image</label>
            @if(isset($product) && $product->image)
                <input type="file" name="image" class="dropify" id="input-file-events"
                       data-default-file="{{ asset($product->image_path)}}"/>

            @else
                <input type="file" name="image" class="dropify"/>
            @endif
            <input type="hidden" name="removeimage" id="removeimage" value=""/>
            <span id="textarea1-error" class="text-danger">{{ $errors->first('image') }}</span>
        </div>
        <div class="col-sm-6">
            <label class="text-default-light">Banner Image(Optional)</label>
            @if(isset($product) && $product->banner_image)
                <input type="file" name="banner_image" class="dropify" id="input-file-events"
                       data-default-file="{{asset($product->banner_path)}}"/>

            @else
                <input type="file" name="banner_image" class="dropify"/>
            @endif
            <input type="hidden" name="removeimage" id="removeimage" value=""/>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-sm-6">
            <label class="text-default-light">Image 1(Optional)</label>
            @if(isset($product) && $product->image1)
                <input type="file" name="image1" class="dropify" id="input-file-events" data-default-file="{{ asset($product->image_path1)}}"/>
            @else
                <input type="file" name="image1" class="dropify"/>
            @endif
            <input type="hidden" name="removeimage" id="removeimage" value=""/>
        </div>
        <div class="col-sm-6">
            <label class="text-default-light">Image 2(Optional)</label>
            @if(isset($product) && $product->image2)
                <input type="file" name="image2" class="dropify" id="input-file-events" data-default-file="{{ asset($product->image_path2)}}"/>
            @else
                <input type="file" name="image2" class="dropify"/>
            @endif
            <input type="hidden" name="removeimage" id="removeimage" value=""/>
        </div>

        <button type="submit" class="btn btn-success" style="margin-top: 30px;position: relative;left: 50%;transform: translateX(-50%)">Submit</button>
    </div>

</div>
<!--end #tab2 -->
