@include('objection.exposed.fields')

@include('timeLimit.exposed.fields')

<div class="form-group @if($errors->first('notification_date')) has-error @endif">
    {!! Form::label('notification_date', 'Fecha de notificación', ['class' => 'control-label']) !!}
    @if(isset($objectionNotification))
        {!! Form::date('notification_date') !!}
    @else
        {!! Form::date('notification_date', \Carbon\Carbon::now()) !!}
    @endif
</div>

<div class="form-group @if($errors->first('finish_date')) has-error @endif">
    {!! Form::label('finish_date', 'Fecha de finalización', ['class' => 'control-label']) !!}
    @if(isset($objection))
        {!! Form::date('finish_date') !!}
    @else
        {!! Form::date('finish_date', \Carbon\Carbon::now()) !!}
    @endif
</div>