<a href="{{ route('employee.create') }}" class="btn">Add New</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Company</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @forelse($employees as $i=>$item)
        <tr>
            <th scope="row">{{ $i+1 }}</th>
            <td>{{$item->name}}</td>
            <td>
                @if ($item->email)
                    <a href="mailto:{{$item->email}}"> {{$item->email}}</a>
                @endif
            </td>
            <td>
                {{$item->phone}}
            </td>
            <td>
                <a href="{!! route('company.show', [$item->company_id]) !!}">
                    {{optional($item->company)->name}}</a>
            </td>
            <td>{{$item->employees_count}}</td>
            <td><a href="{!! route('employee.show', [$item->id]) !!}" class='btn btn-default btn-xs'><i
                        class="glyphicon glyphicon-eye-open"></i></a>
                <a href="{!! route('employee.edit', [$item->id]) !!}" class='btn btn-default btn-xs'><i
                        class="glyphicon glyphicon-edit"></i></a>
            </td>
            <td>
                {!! Form::open('delete'.$item->id)->action( route('employee.destroy',[$item->id]))->method('delete') !!}
                <div class='btn-group'>
                    {!! Form::submit('delete')->text('<i class="glyphicon glyphicon-trash"></i>')
                      ->attribute('onclick', "return confirm('Are you sure?')") !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">No results</td>
        </tr>
    @endforelse
    </tbody>
</table>
