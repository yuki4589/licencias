@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Etapa de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.edit', ['id' => $licenseCurrentStage->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Licencia:</strong> {{ $licenseCurrentStage->license->id }}</p>
            <p><strong>Paso:</strong> {{ $licenseCurrentStage->licenseStage->id }}</p>
            <p><strong>Fecha:</strong> {{ $licenseCurrentStage->date_output }}</p>
            <p><strong>Persona:</strong> {{ $licenseCurrentStage->person->id }}</p>
            <p><strong>Número:</strong> {{ $licenseCurrentStage->number }}</p>
            @if(env('FILE_UPLOAD'))
                <p><strong>Fichero:</strong> <a href="{{ route('file.download', ['file' => $licenseCurrentStage->file->id]) }}" target="_blank">Descargar {{ $licenseCurrentStage->file->filename }}</a></p>
            @endif
            <p><strong>Reparo:</strong> {{ $licenseCurrentStage->objection->id }}</p>
        </div>
    </div>
@endsection

