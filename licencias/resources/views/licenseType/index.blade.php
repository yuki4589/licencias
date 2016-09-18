@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Tipos de licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetype.create') }}" role="button">Dar de Alta un Tipo de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} tipos de licencia actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Tipo de Licencia</th>
                    <th>Descripción</th>
                </tr>
            @foreach($licenseTypes as $licenseType)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('licensetype.show', ['id' => $licenseType->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensetype.edit', ['id' => $licenseType->id]) }}" role="button">Editar</a></td>
                    <td>{{ $licenseType->name }}</td>
                    <td>{{ $licenseType->description }}</td>
                </tr>
                @endforeach
            </table>

            {!! $licenseTypes->render() !!}
        </div>
    </div>
@endsection

