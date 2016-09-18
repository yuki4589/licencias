@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    Denuncia
                </div>
                <div class="col-md-8 text-right">
                    <a class="btn btn-warning" href="{{ route('denunciation.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('license.show', ['id' => $denunciation->license->id]) }}" role="button">Volver a la licencia</a>
                    <a class="btn btn-warning" href="{{ route('denunciation.edit', ['id' => $denunciation->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Licencia:</strong> {{ $denunciation->license->id }}</p>
            <p><strong>Fecha de registro:</strong> {{ $denunciation->register_date_output }}</p>
            <p><strong>Número de expediente:</strong> {{ $denunciation->expedient_number }}</p>

            @if($denunciation->reason)
                <p><strong>Reason:</strong> {{ $denunciation->reason }}</p>
            @endif

            @if(env('FILE_UPLOAD'))
                <p><strong>Fichero:</strong> <a href="{{ route('file.download', ['file' => $denunciation->file->id]) }}" target="_blank">Descargar {{ $denunciation->file->filename }}</a></p>
            @endif
        </div>
    </div>
@endsection

