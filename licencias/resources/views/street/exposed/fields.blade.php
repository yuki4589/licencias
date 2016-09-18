<div class="form-group @if($errors->first('street_id')) has-error @endif">
    {!! Form::label('street_id', 'Vía', ['class' => 'control-label']) !!}
    {!! Form::select('street_id', $streets, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una vía...']) !!}
</div>