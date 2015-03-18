@extends('layouts.layout')

@section('content')
Votre compte a correctement été créé ! 
<a href="{{ URL::route('home') }}	">Retour a l'accueil !</a>
@stop