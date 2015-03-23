{{ Form::open(array('route'=>'uploadAvatar','files'=>true))  }}

    {{ Form::label('image','Image : ') }}
    {{ Form::file('image') }}<br/>
    
    {{Form::submit('Valider',array('class' => 'valid'))}}
    <input type="button" value="Annuler" class='annul'/> 
    
{{ Form::close() }}

@foreach($errors->all() as $e)
        <li>{{{ $e }}}</li>
 @endforeach
 