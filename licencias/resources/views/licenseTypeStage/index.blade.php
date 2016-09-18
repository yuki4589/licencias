@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Asociaciones entre pasos y tipo de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetypestage.create') }}" role="button">Dar de Alta una asociación entre paso y tipo de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} asociaciones entre pasos y tipo de Licencia actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Tipo de Licencia</th>
                    <th>Paso</th>
                    <th>Orden</th>
                    <th>Paso anterior</th>
                    <th>Paso siguiente</th>
                    <th>Genera Licencia</th>
                </tr>

            @foreach($licenseTypeStages as $licenseTypeStage)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('licensetypestage.show', ['id' => $licenseTypeStage->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensetypestage.edit', ['id' => $licenseTypeStage->id]) }}" role="button">Editar</a></td>
                    <td>{{ $licenseTypeStage->licenseType->id }}</td>
                    <td>{{ $licenseTypeStage->licenseStage->id }}</td>
                    <td>{{ $licenseTypeStage->weight }}</td>
                    <td>{{ $licenseTypeStage->previous }}</td>
                    <td>{{ $licenseTypeStage->next }}</td>
                    <td>{{ $licenseTypeStage->license_generate }}</td>
                </tr>
                @endforeach
            </table>

            {!! $licenseTypeStages->render() !!}
        </div>
    </div>
@endsection