@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Vía {{ $street->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('street.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('street.edit', ['id' => $street->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Vía:</strong> {{ $street->name }}</p>
        </div>
    </div>
@endsection

