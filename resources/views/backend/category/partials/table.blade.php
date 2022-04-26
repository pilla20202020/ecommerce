<tr>
    <td>{{++$key}}</td>
    <td><img src="{{asset($category->thumbnail_path)}}" class="img-circle width-1" alt="category_image" width="50" height="50"></td>
    <td class="text-center">{{ Str::limit($category->title, 47) }}</td>
    <td>{{ Str::limit($category->meta_description, 47) }}</td>

    <td class="text-right">
        <a href="{{route('category.edit', $category->slug)}}" class="btn btn-flat btn-primary btn-xs" title="edit">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('category.destroy', $category->id) }}">
            <button type="button"
                class="btn btn-flat btn-danger btn-xs item-delename="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
    </td>
</tr>

