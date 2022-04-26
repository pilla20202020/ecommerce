<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($product->image_path)}}" class="img-circle width-1" alt="{{$product->title}}" width="50" height="50"></td>
    <td>{{ Str::limit($product->title, 47) }}</td>
    <td>{{ Str::limit($product->category->title, 47) }}</td>
    <td>Rs. {{ Str::limit($product->price, 47) }}</td>



    <td class="text-center">
        @if($product->is_featured =='1')
            <span class="badge" style="background-color: #419645">{{$product->is_featured ? 'Yes' : 'No'}}</span>
        @elseif($product->is_featured =='0')
            <span class="badge" style="background-color: #f44336">{{$product->is_featured ? 'Yes' : 'No'}}</span>
        @endif
    </td>
    <td class="text-right">
        {{-- <a href="{{route('product.show', $product->slug)}}" class="btn btn-flat btn-primary btn-xs" title="view" target="_blank">
            <i class="md-remove-red-eye"></i>
        </a> --}}
        <a href="{{ route('product.edit', $product->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('product.destroy', $product->id) }}">
            <button type="button"
                class="btn btn-flat btn-danger btn-xs item-delete" title="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </a>
    </td>
</tr>

