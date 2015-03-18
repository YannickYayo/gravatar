{{ Form::open(array('route'=>'createUser'))  }}

    {{ Form::label('login','Login : ') }}
    {{ Form::text('login') }}<br/>

    {{Form::label('pwd','Mot de Passe : ')}}
    {{Form::password('pwd') }}<br/>
    
    {{Form::label('pwd2','Confirmer Mot de Passe : ')}}
    {{Form::password('pwd2') }}<br/>

    {{Form::label('email','Email : ')}}
    {{Form::text('email') }}<br/>
    
    {{Form::submit('Valider')}}
    
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{ $e }}</li>
@endforeach