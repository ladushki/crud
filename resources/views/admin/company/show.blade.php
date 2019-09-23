@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <h1>Company</h1>
@stop
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
        @include('admin.company.show_fields')
        <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
            </div>
        </div>
        @include('admin.employee.table', ['employees'=>$company->employees])
    </div>
@endsection
