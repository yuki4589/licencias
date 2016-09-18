@if(env('FILE_UPLOAD'))
    <div class="form-group @if($errors->first('filename')) has-error @endif">
        {!! Form::label('filename', 'Fichero', ['class' => 'control-label']) !!}

        @if (isset($file))
            <a href="{{ route('file.download', ['file' => $file->id]) }}" target="_blank">Descargar {{ $file->filename }}</a>
            {!! Form::hidden('file_id', $file->id) !!}
        @endif

        {!! Form::file('filename') !!}

    </div>
@endif