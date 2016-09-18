@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Tipo de licencia {{ $licenseType->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetype.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensetype.edit', ['id' => $licenseType->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Tipo de Licencia:</strong> {{ $licenseType->name }}</p>
            <p><strong>Descripción:</strong> {{ $licenseType->description }}</p>
        </div>
    </div>
@endsection

