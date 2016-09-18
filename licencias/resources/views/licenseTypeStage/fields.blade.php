@include('licenseType.exposed.fields')

<div class="form-group @if($errors->first('license_stage_id')) has-error @endif">
    {!! Form::label('license_stage_id', 'Paso de Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('license_stage_id', $licenseStages, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un paso de licencia...']) !!}
</div>

<div class="form-group @if($errors->first('weight')) has-error @endif">
    {!! Form::label('weight', 'Orden', ['class' => 'control-label']) !!}
    {!! Form::text('weight', null, ['class' => 'form-control', 'id' => 'weight_input', 'placeholder' => 'Orden']) !!}
</div>

<div class="form-group @if($errors->first('previous')) has-error @endif">
    {!! Form::label('previous', 'Paso Anterior de Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('previous', $licenseStages, null, ['class' => 'form-control', 'placeholder' => 'Selecciona el paso anterior de licencia...']) !!}
</div>

<div class="form-group @if($errors->first('next')) has-error @endif">
    {!! Form::label('next', 'Siguiente Paso de Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('next', $licenseStages, null, ['class' => 'form-control', 'placeholder' => 'Selecciona el siguiente paso de licencia...']) !!}
</div>


<div class="checkbox @if($errors->first('license_generate')) has-error @endif">
    <label>
        {!! Form::checkbox('license_generate', 'Genera Licencia') !!} Al finlalizar este paso se genera la licencia
    </label>
</div>