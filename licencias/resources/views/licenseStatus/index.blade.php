@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Estados de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatus.create') }}" role="button">Dar de Alta un Estado de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} estados de licencia actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Estados de Licencia</th>
                </tr>
            @foreach($licenseStatuses as $licenseStatus)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('licensestatus.show', ['id' => $licenseStatus->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensestatus.edit', ['id' => $licenseStatus->id]) }}" role="button">Editar</a></td>
                    <td>{{ $licenseStatus->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $licenseStatuses->render() !!}
        </div>
    </div>
@endsection

