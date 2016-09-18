@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Actividades
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('activity.create') }}" role="button">Dar de Alta una actividad</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} actividades actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Actividad</th>
                </tr>
            @foreach($activities as $activity)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('activity.show', ['id' => $activity->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('activity.edit', ['id' => $activity->id]) }}" role="button">Editar</a></td>
                    <td>{{ $activity->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $activities->render() !!}
        </div>
    </div>
@endsection

