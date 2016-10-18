@extends('layout')

@section('content')
<div ng-app="licenseApp" ng-controller="licenseStageController" ng-cloak>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Paso de Licencia {{ $licenseStage->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestage.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensestage.show', ['id' => $licenseStage->id]) }}" role="button">Volver al Paso de Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseStage, array('route' => array('licensestage.update', $licenseStage->id), 'method' => 'put')) !!}

                @include('licenseStage.fields')
            
                {!! Form::button('Guardar cambios en el paso ' . $licenseStage->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection