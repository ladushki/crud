@extends('adminlte::page')

@section('title', 'Employee')

@section('content_header')
    <h1>Edit Employee</h1>
@stop

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                {!! $form !!}
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@stop
