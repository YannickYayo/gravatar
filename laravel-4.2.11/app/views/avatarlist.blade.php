@extends('layouts.layout')

@section('content')

<a href="{{ URL::route('logout') }}" class="disconnect">Deconnexion</a>
<a href="{{ URL::route('addAvatar') }}" class="add"> Ajouter un avatar</a>
<br /><br />

liste des avatars de {{ $login }} : <br/>

@foreach($avatars as $a)
	@if(preg_match('#'.'300x300'.'#', $a['image']))
	<div>
		<img src="/avatars/{{ $a['email']  }}/{{ $a['image'] }}" /><br/>
		<a href="/delete/{{ substr($a['image'], 0, 10) }}" class="supp">Supprimer</a>
	</div>
	@endif
@endforeach





@stop