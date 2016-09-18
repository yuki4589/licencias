@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Limites de entrega
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('timelimit.create') }}" role="button">Dar de Alta un limite de entrega</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} límites de entrega actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Orden de ejecución</th>
                    <th>Días</th>
                </tr>
            @foreach($timeLimits as $timeLimit)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('timelimit.show', ['id' => $timeLimit->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('timelimit.edit', ['id' => $timeLimit->id]) }}" role="button">Editar</a></td>
                    <td>{{ $timeLimit->weight }}</td>
                    <td>{{ $timeLimit->days }}</td>
                </tr>
                @endforeach
            </table>

            {!! $timeLimits->render() !!}
        </div>
    </div>
@endsection

