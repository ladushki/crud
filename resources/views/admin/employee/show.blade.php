@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <h1>Company</h1>
@stop
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                @include('admin.employee.show_fields')
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection
