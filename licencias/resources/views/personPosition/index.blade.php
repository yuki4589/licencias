@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Posiciones
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('personposition.create') }}" role="button">Dar de Alta una posición</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} posiciones actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Posición</th>
                </tr>
            @foreach($personPositions as $personPosition)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('personposition.show', ['id' => $personPosition->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('personposition.edit', ['id' => $personPosition->id]) }}" role="button">Editar</a></td>
                    <td>{{ $personPosition->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $personPositions->render() !!}
        </div>
    </div>
@endsection

