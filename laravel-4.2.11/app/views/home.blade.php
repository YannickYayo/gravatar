@extends('layouts.layout')

@section('content')

Bienvenue sur Gravatar
<br />
<a href="{{ URL::route('newUser') }}">Creer un compte</a>
<a href="{{ URL::route('login') }}">Log in</a>

@stop