@include('license.exposed.fields')

@include('licenseStage.exposed.fields')

<div class="form-group @if($errors->first('first_position_person_id')) has-error @endif">
    {!! Form::label('first_person_position_id', 'Primera Posición de Persona', ['class' => 'control-label']) !!}
    {!! Form::select('first_person_position_id', $personPositions, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una posición...']) !!}
</div>

<div class="form-group @if($errors->first('second_position_person_id')) has-error @endif">
    {!! Form::label('second_person_position_id', 'Segunda Posición de Persona', ['class' => 'control-label']) !!}
    {!! Form::select('second_person_position_id', $personPositions, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una posición...']) !!}
</div>

<div class="form-group @if($errors->first('report_date')) has-error @endif">
    {!! Form::label('report_date', 'Fecha de reporte', ['class' => 'control-label']) !!}
    @if(isset($objection))
        {!! Form::date('report_date') !!}
    @else
        {!! Form::date('report_date', \Carbon\Carbon::now()) !!}
    @endif
</div>

<div class="form-group @if($errors->first('correction_date')) has-error @endif">
    {!! Form::label('correction_date', 'Fecha de corrección', ['class' => 'control-label']) !!}
    @if(isset($objection))
        {!! Form::date('correction_date') !!}
    @else
        {!! Form::date('correction_date', \Carbon\Carbon::now()) !!}
    @endif
</div>

@include('file.exposed.fields')