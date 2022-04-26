<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($training->thumbnail_path)}}" class="img-circle width-1" alt="training_image" width="50" height="50"></td>
    <td>{{ Str::limit($training->title, 47) }}</td>
    <td class="text-center">{{ ($training->training_date)->format('Y-m-d') }}</td>

    <td class="text-center">
        @if($training->is_published =='1')
            <span class="badge" style="background-color: #419645">{{$training->is_published ? 'Yes' : 'No'}}</span>
        @elseif($training->is_published =='0')
            <span class="badge" style="background-color: #f44336">{{$training->is_published ? 'Yes' : 'No'}}</span>
        @endif    </td>
    <td class="text-right">
        <a href="{{route('training.edit', $training->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('training.destroy', $training->id) }}">
        <button type="button" 
            class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
    </td>
</tr>

