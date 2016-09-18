<div class="form-group @if($errors->first('user_type_id')) has-error @endif">
    {!! Form::label('user_type_id', 'Selecciona un tipo de usuario', ['class' => 'control-label']) !!}
    {!! Form::select('user_type_id', $userTypes, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo de usuario...']) !!}
</div>