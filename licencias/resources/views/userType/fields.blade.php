<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Tipo de usuario', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Tipo de usuario']) !!}
</div>