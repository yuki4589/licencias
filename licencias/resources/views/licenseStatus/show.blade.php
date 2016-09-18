@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Estado de Licencia {{ $licenseStatus->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatus.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensestatus.edit', ['id' => $licenseStatus->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Estado de Licencia:</strong> {{ $licenseStatus->name }}</p>
        </div>
    </div>
@endsection

