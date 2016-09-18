@if(isset($licenseStages))
    <div class="form-group @if($errors->first('license_stage_id')) has-error @endif">
        {!! Form::label('license_stage_id', 'Paso de Licencia', ['class' => 'control-label']) !!}
        {!! Form::select('license_stage_id', $licenseStages, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un paso de licencia...', 'ng-model' => 'licenseTypeId']) !!}
    </div>
@elseif(isset($license->current_stage))
    {!! Form::hidden('license_stage_id', $license->current_stage->id, ['ng-model' => 'licenseTypeId']) !!}
@endif