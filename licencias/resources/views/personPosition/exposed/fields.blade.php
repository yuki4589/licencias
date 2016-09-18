<div class="form-group @if($errors->first('position_person_id')) has-error @endif">
    {!! Form::label('person_position_id', 'Selecciona una posición', ['class' => 'control-label']) !!}
    {!! Form::select('person_position_id', $personPositions, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una posicion...']) !!}
</div>