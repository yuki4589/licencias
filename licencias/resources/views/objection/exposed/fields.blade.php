<div class="form-group @if($errors->first('objection_id')) has-error @endif">
    {!! Form::label('objection_id', 'Selecciona un reparo', ['class' => 'control-label']) !!}
    {!! Form::select('objection_id', $objections, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un reparo...']) !!}
</div>