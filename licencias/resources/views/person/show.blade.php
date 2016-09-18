@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Persona: {{ $person->first_name }} {{ $person->last_name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('person.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('person.edit', ['id' => $person->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Nombre:</strong> {{ $person->first_name }}</p>
            <p><strong>Apellidos:</strong> {{ $person->last_name }}</p>
            <p><strong>Posición:</strong> {{ $person->personPosition->name }}</p>
            <p><strong>Correo electrónico:</strong> {{ $person->email }}</p>
        </div>
    </div>
@endsection

