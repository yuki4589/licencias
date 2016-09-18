<div class="form-group @if($errors->first('activity_id')) has-error @endif">
    {!! Form::label('activity_id', 'Actividad', ['class' => 'control-label']) !!}
    {!! Form::select('activity_id', $activities, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una actividad...']) !!}
</div>