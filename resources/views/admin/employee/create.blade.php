@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Employee</h1>
@stop

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                {!! $form !!}
            </div>
        </div>
    </div>
@stop
