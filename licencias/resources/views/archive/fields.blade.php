<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Archivador', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Archivador']) !!}
</div>

<div class="form-group @if($errors->first('place')) has-error @endif">
    {!! Form::label('place', 'Lugar', ['class' => 'control-label']) !!}
    {!! Form::text('place', null, ['class' => 'form-control', 'id' => 'place_input', 'placeholder' => 'Lugar']) !!}
</div>