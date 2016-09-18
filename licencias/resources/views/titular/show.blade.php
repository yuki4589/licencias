@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Titular: {{ $titular->first_name }} {{ $titular->last_name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('titular.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('titular.edit', ['id' => $titular->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>NIF:</strong> {{ $titular->nif }}</p>
            <p><strong>Nombre:</strong> {{ $titular->first_name }}</p>
            <p><strong>Apellidos:</strong> {{ $titular->last_name }}</p>
            <p><strong>Número de teléfono:</strong> {{ $titular->phone_number }}</p>
            <p><strong>Correo electrónico:</strong> {{ $titular->email }}</p>
        </div>
    </div>
@endsection

