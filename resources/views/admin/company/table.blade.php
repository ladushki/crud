<a href="{{ route('company.create') }}" class="btn">Add New</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Website</th>
        <th scope="col">Logo</th>
        <th scope="col">Employee number</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @forelse($companies as $i=>$item)
        <tr>
            <th scope="row">{{ $i+1 }}</th>
            <td>{{$item->name}}</td>
            <td>
                @if ($item->email)
                    <a href="mailto:{{$item->email}}"> {{$item->email}}</a>
                @endif
            </td>
            <td>
                @if ($item->website)
                    <a href="{{ $item->website }}">{{ $item->website }}</a>
                @endif
            </td>
            <td>
                @if ($item->logo)
                    <img src="{{  asset('images/'.$item->logo)}}" alt="{{$item->name}}" width="80" height="80"/>
                @else
                    <img src="https://via.placeholder.com/80/0000FF/808080" alt="{{$item->name}}" width="80"
                         height="80"/>
                @endif
            </td>
            <td>{{$item->employees_count}}</td>
            <td><a href="{!! route('company.show', [$item->id]) !!}" class='btn btn-default btn-xs'><i
                        class="glyphicon glyphicon-eye-open"></i></a>
                <a href="{!! route('company.edit', [$item->id]) !!}" class='btn btn-default btn-xs'><i
                        class="glyphicon glyphicon-edit"></i></a>
            </td>
            <td>
                {!! Form::open('delete'.$item->id)->action( route('company.destroy',[$item->id]))->method('delete') !!}
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
