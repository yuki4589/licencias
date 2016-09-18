<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Posición', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Posición']) !!}
</div>