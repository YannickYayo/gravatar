@extends('layouts.layout')

@section('content')

{{ Form::open(array('route'=>'uploadAvatar','files'=>true))  }}

    {{ Form::label('image','Image : ') }}
    {{ Form::file('image') }}<br/>
    
    {{Form::submit('Valider')}}
    
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{{ $e }}}</li>
 @endforeach
 
 @stop