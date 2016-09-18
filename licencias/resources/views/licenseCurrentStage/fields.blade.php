@include('license.exposed.fields')

<div class="form-group @if($errors->first('license_stage_id')) has-error @endif">
    {!! Form::label('license_stage_id', 'Paso de Licencia', ['class' => 'control-label']) !!}
    {!! Form::select('license_stage_id', $licenseStages, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un paso de licencia...']) !!}
</div>

<div class="form-group @if($errors->first('date')) has-error @endif">
    {!! Form::label('date', 'Fecha', ['class' => 'control-label']) !!}
    @if(isset($licenseCurrentStage))
        {!! Form::date('date') !!}
    @else
        {!! Form::date('date', \Carbon\Carbon::now()) !!}
    @endif
</div>

@include('person.exposed.fields')

<div class="form-group @if($errors->first('number')) has-error @endif">
    {!! Form::label('number', 'Número', ['class' => 'control-label']) !!}
    {!! Form::text('number', null, ['class' => 'form-control', 'id' => 'number_input', 'placeholder' => 'Número']) !!}
</div>

@include('file.exposed.fields')

@include('objection.exposed.fields')