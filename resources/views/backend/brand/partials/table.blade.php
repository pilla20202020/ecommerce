<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($brand->thumbnail_path)}}" class="img-circle width-1" alt="brand_image" width="50" height="50"></td>
    <td>{{ Str::limit($brand->title, 47) }}</td>

    <td class="text-center">
        @if($brand->is_published =='1')
            <span class="badge" style="background-color: #419645">{{$brand->is_published ? 'Yes' : 'No'}}</span>
        @elseif($brand->is_published =='0')
            <span class="badge" style="background-color: #f44336">{{$brand->is_published ? 'Yes' : 'No'}}</span>
        @endif    </td>
    <td class="text-right">
        <a href="{{route('brand.edit', $brand->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('brand.destroy', $brand->id) }}">
        <button type="button" 
            class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
    </td>
</tr>

