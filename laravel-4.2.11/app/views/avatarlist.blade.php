@extends('layouts.layout')

@section('content')

<a href="{{ URL::route('logout') }}" class="disconnect">Deconnexion</a>
<a href="{{ URL::route('addAvatar') }}" class="add"> Ajouter un avatar</a>
<br /><br />

liste des avatars de {{ $login }} : <br/>
@foreach($avatars as $a)
	<div>
		<img src="/avatars/{{ $a['image'] }}" /><br/>
		<a href="/delete/{{ $a['id'] }}" class="supp">Supprimer</a>
	</div>
@endforeach


<script>

$.widget('gravatar.avatarList',{
	_create: function() {
		this.options.suppButton = $('.supp');
		this.options.suppButton.bind('click', $.proxy(this.suppClicked, this));
		alert('1111');
	},
	suppClicked: function(event){
		alert('test');
		return false;
	},
	options: {
		modal: null,
	}
});
$(document).ready(function() {
	$('#content').avatarList();
});
</script>


@stop