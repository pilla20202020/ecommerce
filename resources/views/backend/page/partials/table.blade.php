<tr>
    <td>{{++$key}}</td>
    <td>{{ Str::limit($page->title, 47) }}</td>

    <td class="text-center">
        @if($page->is_published =='1')
            <span class="badge" style="background-color: #419645">{{$page->is_published ? 'Yes' : 'No'}}</span>
        @elseif($page->is_published =='0')
            <span class="badge" style="background-color: #f44336">{{$page->is_published ? 'Yes' : 'No'}}</span>
        @endif
    </td>
    <td class="text-right">
        <a href="{{route('page.edit', $page->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
         <a href="{{ route('page.destroy', $page->id) }}">
            <button type="button" data-url="{{ route('page.destroy', $page->slug) }}"
                    class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
    </td>
</tr>
