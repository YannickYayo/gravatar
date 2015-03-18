@extends('layouts.layout')

@section('content')

<a href="{{ URL::route('logout') }}">Deconnexion</a>
<a href="{{ URL::route('addAvatar') }}"> Ajouter un avatar</a>
<br />

liste des avatars de {{ $login }} : <br/>
@foreach($avatars as $a)
	<div>
		<img src="/avatars/{{ $a['image'] }}" /><br/>
		<a href="/delete/{{ $a['id'] }}">Supprimer</a>
	</div>
@endforeach

@stop