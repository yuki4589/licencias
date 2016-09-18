@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Fichero
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('file.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('file.edit', ['id' => $file->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><a href="{{ route('file.download', ['file' => $file->id]) }}" target="_blank">Descargar {{ $file->filename }}</a></p>
        </div>
    </div>
@endsection

