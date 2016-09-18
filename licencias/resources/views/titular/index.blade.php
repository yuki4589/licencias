@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Titulares
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('titular.create') }}" role="button">Dar de Alta un titular</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} titulares actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>NIF</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Número de teléfono</th>
                    <th>Correo electrónico</th>
                </tr>
            @foreach($titulars as $titular)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('titular.show', ['id' => $titular->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('titular.edit', ['id' => $titular->id]) }}" role="button">Editar</a></td>
                    <td>{{ $titular->nif }}</td>
                    <td>{{ $titular->first_name }}</td>
                    <td>{{ $titular->last_name }}</td>
                    <td>{{ $titular->phone_number }}</td>
                    <td>{{ $titular->email }}</td>
                </tr>
                @endforeach
            </table>

            {!! $titulars->render() !!}
        </div>
    </div>
@endsection

