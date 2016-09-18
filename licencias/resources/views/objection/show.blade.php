@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Reparo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objection.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('objection.edit', ['id' => $objection->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Licencia:</strong> {{ $objection->license->id }}</p>
            <p><strong>Primera Posición Persona:</strong> {{$objection->firstPersonPosition->name }}</p>

            @if($objection->secondPersonPosition)
                    <p><strong>Segunda Posición Persona:</strong> {{$objection->secondPersonPosition->name }}</p>
            @endif

            <p><strong>Fecha de reporte:</strong> {{ $objection->report_date_output }}</p>
            <p><strong>Fecha de corrección:</strong> {{ $objection->correction_date_output }}</p>
            @if(env('FILE_UPLOAD'))
                <p><strong>Fichero:</strong> <a href="{{ route('file.download', ['file' => $objection->file->id]) }}" target="_blank">Descargar {{ $objection->file->filename }}</a></p>
            @endif
        </div>
    </div>
@endsection