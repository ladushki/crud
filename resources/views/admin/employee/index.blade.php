@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')
  @include('admin.employee.table')
  {{ $employees->links() }}
@stop
