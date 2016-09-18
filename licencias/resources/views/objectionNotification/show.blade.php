@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Notificación de Reparo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objectionnotification.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('objectionnotification.edit', ['id' => $objectionNotification->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Reparo:</strong> {{ $objectionNotification->objection->id }}</p>
            <p><strong>Limite de Días:</strong> {{$objectionNotification->timeLimit->days }}</p>
            <p><strong>Fecha de notificación:</strong> {{ $objectionNotification->notification_date_output }}</p>
            <p><strong>Fecha de finalización:</strong> {{ $objectionNotification->finish_date_output }}</p>
        </div>
    </div>
@endsection