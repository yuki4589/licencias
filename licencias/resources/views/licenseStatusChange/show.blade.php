@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Cambio en el Estado de la Licencia {{ $licenseStatusChange->license->id }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.edit', ['id' => $licenseStatusChange->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Licencia:</strong> {{ $licenseStatusChange->license->id }}</p>
            <p><strong>Estado de Licencia:</strong> {{ $licenseStatusChange->licenseStatus->name }}</p>
            <p><strong>Fecha de Cambio:</strong> {{ $licenseStatusChange->change_date_output }}</p>
        </div>
    </div>
@endsection

