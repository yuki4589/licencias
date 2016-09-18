<div class="form-group @if($errors->first('archive_id')) has-error @endif">
    {!! Form::label('archive_id', 'Archivador', ['class' => 'control-label']) !!}
    {!! Form::select('archive_id', $archives, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un archivador...']) !!}
</div>