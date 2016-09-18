@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Etapa de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.create') }}" role="button">Dar de Alta una Etapa de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} etapas de licencia actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Licencia</th>
                    <th>Paso</th>
                    <th>Fecha</th>
                    <th>Persona</th>
                    <th>Número</th>
                    @if(env('FILE_UPLOAD'))
                        <th>Fichero</th>
                    @endif
                    <th>Reparo</th>
                </tr>

            @foreach($licenseCurrentStages as $licenseCurrentStage)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('licensecurrentstage.show', ['id' => $licenseCurrentStage->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensecurrentstage.edit', ['id' => $licenseCurrentStage->id]) }}" role="button">Editar</a></td>
                    <td>{{ $licenseCurrentStage->license->id }}</td>
                    <td>{{ $licenseCurrentStage->licenseStage->id }}</td>
                    <td>{{ $licenseCurrentStage->date_output }}</td>
                    <td>{{ $licenseCurrentStage->person->id }}</td>
                    <td>{{ $licenseCurrentStage->number }}</td>
                    @if(env('FILE_UPLOAD'))
                        <td><a href="{{ route('file.download', ['file' => $licenseCurrentStage->file->id]) }}" target="_blank">Descargar {{ $licenseCurrentStage->file->filename }}</a></td>
                    @endif
                    <td>{{ $licenseCurrentStage->objection->id }}</td>
                </tr>
                @endforeach
            </table>

            {!! $licenseCurrentStages->render() !!}
        </div>
    </div>
@endsection

