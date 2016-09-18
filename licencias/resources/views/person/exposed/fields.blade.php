<div class="form-group @if($errors->first('person_id')) has-error @endif">
    {!! Form::label('person_id', 'Selecciona una persona', ['class' => 'control-label']) !!}
    {!! Form::select('person_id', $people, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una persona...']) !!}
</div>