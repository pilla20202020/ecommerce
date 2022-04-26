<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($subcategory->thumbnail_path)}}" class="img-circle width-1" alt="{{$subcategory->title}}" width="50" height="50"></td>
    <td>{{ Str::limit($subcategory->title, 47) }}</td>
    <td>{{ Str::limit($subcategory->category->title, 47) }}</td>

    <td class="text-center">
        @if($subcategory->is_published =='1')
            <span class="badge" style="background-color: #419645">{{$subcategory->is_published ? 'Yes' : 'No'}}</span>
        @elseif($subcategory->is_published =='0')
            <span class="badge" style="background-color: #f44336">{{$subcategory->is_published ? 'Yes' : 'No'}}</span>
        @endif    </td>
    <td class="text-right">
        <a href="{{ route('subcategory.edit', $subcategory->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('subcategory.destroy', $subcategory->id) }}">
            <button type="button"
                class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
    </td>
</tr>

