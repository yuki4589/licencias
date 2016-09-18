@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Actividad {{ $activity->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('activity.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('activity.edit', ['id' => $activity->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Actividad:</strong> {{ $activity->name }}</p>
        </div>
    </div>
@endsection

