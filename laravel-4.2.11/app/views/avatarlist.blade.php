<a href="{{ URL::route('logout') }}">Deconnexion</a><br />

liste des avatars de {{ $login }} : <br/>
@foreach($avatars as $a)
	<img src="/avatars/{{ $a['image'] }}"/><br/>
@endforeach