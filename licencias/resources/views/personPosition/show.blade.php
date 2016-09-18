@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Posición {{ $personPosition->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('personposition.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('personposition.edit', ['id' => $personPosition->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Posición:</strong> {{ $personPosition->name }}</p>
        </div>
    </div>
@endsection

