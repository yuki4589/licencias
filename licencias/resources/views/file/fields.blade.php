<div class="form-group @if($errors->first('filename')) has-error @endif">
    {!! Form::label('filename', 'Fichero', ['class' => 'control-label']) !!}

    @if (isset($file))
        <a href="{{ route('file.download', ['file' => $file->id]) }}" target="_blank">Descargar {{ $file->filename }}</a>
    @endif

    {!! Form::file('filename') !!}

</div>