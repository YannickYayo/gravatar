Connectez vous : 

 {{ Form::open(array('route'=>'logMe'))  }}

    {{ Form::label('login','Login : ') }}
    {{ Form::text('login') }}<br/>

    {{Form::label('pwd','Mot de Passe : ')}}
    {{Form::password('pwd') }}<br/>

    {{Form::submit('Valider')}}
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{{ $e }}}</li>
 @endforeach