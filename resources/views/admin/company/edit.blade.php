@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Update the Company - <?=$form->name->getValue() ?></h1>
@stop

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-1">
                @if ($form->logo->getValue())
                    <img src="{{  asset('images/'.$form->logo->getValue())}}" alt="{{$form->name->getValue()}}" width="80" height="80"/>
                @endif
            </div>
            <div class="col-lg-8">
                {!! $form !!}
            </div>
        </div>
    </div>
    <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
@stop
