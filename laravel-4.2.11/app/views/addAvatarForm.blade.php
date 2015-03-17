{{ Form::open(array('route'=>'uploadAvatar'))  }}

    {{ Form::label('photo','Image : ') }}
    {{ Form::file('photo') }}<br/>
    
    {{Form::submit('Valider')}}
    
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{{ $e }}}</li>
 @endforeach