@extends('layouts.layout')

@section('content')



 {{ Form::open(array('route'=>'logMe'))  }}
 <h1>Connectez vous : </h1><br/><br/>

    {{ Form::label('login','Login : ') }}
    {{ Form::text('login') }}<br/><br/>

    {{Form::label('pwd','Mot de Passe : ')}}
    {{Form::password('pwd') }}<br/><br/>

    {{Form::submit('Valider')}}
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{{ $e }}}</li>
 @endforeach
 
 @stop