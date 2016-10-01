@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar alerta: {{ $objetoAlerta->title }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('alert.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($objetoAlerta, array('route' => array('alert.update', $objetoAlerta->id), 'method' => 'put', 'autocomplete' => 'off')) !!}

                @include('alert.fields')
            
                {!! Form::button('Guardar', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('alertController', ['$scope', '$http', function ($scope, $http) {
            $scope.alert = {};
            angular.element(document).ready(function () {
                $('.date').datetimepicker({
                    locale: 'es',
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            });
        }]);
    </script>
@endsection