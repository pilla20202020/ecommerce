<tr>
    <td>{{++$key}}</td>
    <td>{{ Str::limit($contact->fullname, 47) }}</td>
    <td>{{ Str::limit($contact->email, 47) }}</td>
    <td>{{$contact->subject}}</td>
    <td>{{$contact->message}}</td>
    <td class="text-right">
        <a href="{{ route('contact.destroy', $contact->id) }}">
            <button type="button"
                class="btn btn-flat btn-danger btn-xs item-delename="delete">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </a>
    </td>
</tr>

