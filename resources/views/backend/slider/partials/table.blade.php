<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($slide->thumbnail_path)}}" class="img-circle width-1" alt="slide_image" width="50" height="50"></td>
    <td>{{ Str::limit($slide->title, 47) }}</td>
{{--    <td class="text-center">{{ Carbon\Carbon::parse($slide->date)->format('Y-m-d') }}</td>--}}

   
    <td class="text-right">
        <a href="{{route('slider.edit', $slide->id)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('slider.destroy', $slide->id) }}">
            <button type="button" 
                    class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </a>
    </td>
</tr>

