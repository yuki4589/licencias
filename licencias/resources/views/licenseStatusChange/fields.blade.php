@include('license.exposed.fields')

@include('licenseStatus.exposed.fields')

<div class="form-group @if($errors->first('change_date')) has-error @endif">
    {!! Form::label('change_date', 'Fecha de cambio', ['class' => 'control-label']) !!}
    @if(isset($licenseStatusChange))
        {!! Form::date('change_date') !!}
    @else
        {!! Form::date('change_date', \Carbon\Carbon::now()) !!}
    @endif
</div>