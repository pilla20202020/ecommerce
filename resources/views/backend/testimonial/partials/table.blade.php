<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($testimonial->thumbnail_path)}}" class="img-circle width-1" alt="{{$testimonial->title}}" width="50" height="50"></td>
    <td>{{ Str::limit($testimonial->title, 47) }}</td>
    <td>{{ Str::limit($testimonial->content, 47) }}</td>
    <td class="text-center">
        @if($testimonial->is_featured =='1')
            <span class="badge" style="background-color: #419645">{{$testimonial->is_featured ? 'Yes' : 'No'}}</span>
        @elseif($testimonial->is_featured =='0')
            <span class="badge" style="background-color: #f44336">{{$testimonial->is_featured ? 'Yes' : 'No'}}</span>
        @endif
    </td>

    <td class="text-right">
        <a href="{{route('testimonial.edit', $testimonial->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('testimonial.destroy', $testimonial->id) }}">
        <button type="button"
            class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
    </td>
</tr>
