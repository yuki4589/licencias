@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Reparos
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objection.create') }}" role="button">Dar de Alta un Reparo</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} reparos actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Licencia</th>
                    <th>Primera Posición de Persona</th>
                    <th>Segunda Posición de Persona</th>
                    <th>Fecha de reporte</th>
                    <th>Fecha de corrección</th>
                    @if(env('FILE_UPLOAD'))
                        <th>Fichero</th>
                    @endif
                </tr>
            @foreach($objections as $objection)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('objection.show', ['id' => $objection->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('objection.edit', ['id' => $objection->id]) }}" role="button">Editar</a></td>
                    <td>{{ $objection->license->id }}</td>
                    <td>{{ $objection->firstPersonPosition->name }}</td>
                    <td>
                        @if($objection->secondPersonPosition)
                            {{ $objection->secondPersonPosition->name }}
                        @endif
                    </td>
                    <td>{{ $objection->report_date_output }}</td>
                    <td>{{ $objection->correction_date_output }}</td>
                    @if(env('FILE_UPLOAD'))
                        <td><a href="{{ route('file.download', ['file' => $objection->file->id]) }}" target="_blank">Descargar {{ $objection->file->filename }}</a></td>
                    @endif
                </tr>
                @endforeach
            </table>

            {!! $objections->render() !!}
        </div>
    </div>
@endsection

