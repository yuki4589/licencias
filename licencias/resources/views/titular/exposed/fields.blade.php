<div class="form-group @if($errors->first('titular_id')) has-error @endif">
    {!! Form::label('titular_id', 'Titular', ['class' => 'control-label']) !!}
    {!! Form::select('titular_id', $titulars, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un titular...']) !!}
</div>