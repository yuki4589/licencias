<div class="form-group @if($errors->first('license_status_id')) has-error @endif">
    {!! Form::label('license_status_id', 'Estado de la Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('license_status_id', $licenseStatuses, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un estado de licencia...']) !!}
</div>