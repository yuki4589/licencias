@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Notificaciones de Reparos
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objectionnotification.create') }}" role="button">Dar de Alta una Notificación de Reparo</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} notificaciones de reparos actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Reparo</th>
                    <th>Limite de tiempo</th>
                    <th>Fecha de notificación</th>
                    <th>Fecha de finalización</th>
                </tr>
            @foreach($objectionNotifications as $objectionNotification)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('objectionnotification.show', ['id' => $objectionNotification->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('objectionnotification.edit', ['id' => $objectionNotification->id]) }}" role="button">Editar</a></td>
                    <td>{{ $objectionNotification->objection->id }}</td>
                    <td>{{ $objectionNotification->timeLimit->days }}</td>
                    <td>{{ $objectionNotification->notification_date_output }}</td>
                    <td>{{ $objectionNotification->finish_date_output }}</td>
                </tr>
                @endforeach
            </table>

            {!! $objectionNotifications->render() !!}
        </div>
    </div>
@endsection