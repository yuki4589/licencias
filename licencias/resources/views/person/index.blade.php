@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Personas
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('person.create') }}" role="button">Dar de Alta una persona</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} personas actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Posición</th>
                    <th>Correo electrónico</th>
                </tr>
            @foreach($people as $person)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('person.show', ['id' => $person->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('person.edit', ['id' => $person->id]) }}" role="button">Editar</a></td>
                    <td>{{ $person->first_name }}</td>
                    <td>{{ $person->last_name }}</td>
                    <td>{{ $person->personPosition->name }}</td>
                    <td>{{ $person->email }}</td>
                </tr>
                @endforeach
            </table>

            {!! $people->render() !!}
        </div>
    </div>
@endsection

