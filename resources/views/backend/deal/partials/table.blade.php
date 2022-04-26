<tr>
    <td>{{++$key}}</td>
    <td>{{ Str::limit($deal->product->title, 47) }}</td>
    <td>{{ Str::limit($deal->offer_price, 47) }}</td>

    <td class="text-center">
        @if($deal->is_featured =='1')
            <span class="badge" style="background-color: #419645">{{$deal->is_featured ? 'Yes' : 'No'}}</span>
        @elseif($deal->is_featured =='0')
            <span class="badge" style="background-color: #f44336">{{$deal->is_featured ? 'Yes' : 'No'}}</span>
        @endif
    </td>
    <td class="text-right">
        <a href="{{route('deal.edit', $deal->id)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('deal.destroy', $deal->id) }}">
            <button type="button"
                class="btn btn-flat btn-danger btn-xs item-delename="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
    </td>
</tr>

