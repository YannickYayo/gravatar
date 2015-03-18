@extends('layouts.layout')

@section('content')

{{ Form::open(array('route'=>'createUser'))  }}

    {{ Form::label('login','Login : ') }}
    {{ Form::text('login') }}<br/><br/>

    {{Form::label('pwd','Mot de Passe : ')}}
    {{Form::password('pwd') }}<br/><br/>
    
    {{Form::label('pwd2','Confirmer Mot de Passe : ')}}
    {{Form::password('pwd2') }}<br/><br/>

    {{Form::label('email','Email : ')}}
    {{Form::text('email') }}<br/><br/>
    
    {{Form::submit('Valider')}}
    
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{ $e }}</li>
@endforeach

@stop