@extends('adminlte::page')

@section('title', 'Companies')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')
    @include('admin.company.table')
    {{ $companies->links() }}
@stop
