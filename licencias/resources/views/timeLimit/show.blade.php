@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Límite de entrega
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('timelimit.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('timelimit.edit', ['id' => $timeLimit->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Orden de ejecución:</strong> {{ $timeLimit->weight }}</p>
            <p><strong>Días:</strong> {{ $timeLimit->days }}</p>
        </div>
    </div>
@endsection

