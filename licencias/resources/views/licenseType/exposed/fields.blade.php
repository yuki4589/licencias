<div class="form-group @if($errors->first('license_type_id')) has-error @endif">
    {!! Form::label('license_type_id', 'Tipo de Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('license_type_id', $licenseTypes, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo de licencia...']) !!}
</div>