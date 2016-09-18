@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Cambios en Estados de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.create') }}" role="button">Dar de Alta un Cambio de Estado de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} cambios de estados de licencia actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Licencia</th>
                    <th>Estado</th>
                    <th>Fecha de cambio</th>
                </tr>
            @foreach($licenseStatusChanges as $licenseStatusChange)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('licensestatuschange.show', ['id' => $licenseStatusChange->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensestatuschange.edit', ['id' => $licenseStatusChange->id]) }}" role="button">Editar</a></td>
                    <td>{{ $licenseStatusChange->license->id }}</td>
                    <td>{{ $licenseStatusChange->licenseStatus->name }}</td>
                    <td>{{ $licenseStatusChange->change_date_output }}</td>

                </tr>
                @endforeach
            </table>

            {!! $licenseStatusChanges->render() !!}
        </div>
    </div>
@endsection

