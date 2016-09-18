@if(isset($license))
    {!! Form::hidden('license_id', $license->id) !!}
@elseif(isset($denunciation))
    {!! Form::hidden('license_id', $denunciation->license_id) !!}
@else
    <div class="form-group @if($errors->first('license_id')) has-error @endif">
        {!! Form::label('license_id', 'Licencia', ['class' => 'control-label']) !!}
        {!! Form::select('license_id', $licenses, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una licencia...']) !!}
    </div>
@endif

<div class="form-group @if($errors->first('register_date')) has-error @endif">
    {!! Form::label('register_date', 'Fecha de registro', ['class' => 'control-label']) !!}
    @if(isset($denunciation))
        {!! Form::date('register_date') !!}
    @else
        {!! Form::date('register_date', \Carbon\Carbon::now()) !!}
    @endif
</div>

<div class="form-group @if($errors->first('expedient_number')) has-error @endif">
    {!! Form::label('expedient_number', 'Número de expediente', ['class' => 'control-label']) !!}
    {!! Form::text('expedient_number', null, ['class' => 'form-control', 'id' => 'expedient_number_input', 'placeholder' => 'Número de expediente']) !!}
</div>

<div class="form-group @if($errors->first('reason')) has-error @endif">
    {!! Form::label('reason', 'Razón', ['class' => 'control-label']) !!}
    {!! Form::text('reason', null, ['class' => 'form-control', 'id' => 'reason_input', 'placeholder' => 'Razón']) !!}
</div>

@include('file.exposed.fields')