@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Asociación entre pasos y tipo de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetypestage.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensetypestage.edit', ['id' => $licenseTypeStage->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Tipo de Licencia:</strong> {{ $licenseTypeStage->licenseType->id }}</p>
            <p><strong>Paso:</strong> {{ $licenseTypeStage->licenseStage->id }}</p>
            <p><strong>Orden:</strong> {{ $licenseTypeStage->weight }}</p>
            <p><strong>Paso anterior:</strong> {{ $licenseTypeStage->previous }}</p>
            <p><strong>Paso siguiente:</strong> {{ $licenseTypeStage->next }}</p>
            <p><strong>Genera Licencia:</strong> {{ $licenseTypeStage->license_generate }}</p>
        </div>
    </div>
@endsection

