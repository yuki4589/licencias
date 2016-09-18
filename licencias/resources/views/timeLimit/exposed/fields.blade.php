<div class="form-group @if($errors->first('time_limit_id')) has-error @endif">
    {!! Form::label('time_limit_id', 'Selecciona un límite de tiempo', ['class' => 'control-label']) !!}
    {!! Form::select('time_limit_id', $timeLimits, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un límite de tiempo...']) !!}
</div>