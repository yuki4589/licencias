@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Alta de alertas
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('alert.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'alert.store', 'autocomplete' => 'off')) !!}
                @include('alert.fields')
                {!! Form::button('Crear alerta', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('alertController', ['$scope', '$http', function ($scope, $http) {
            angular.element(document).ready(function () {
                $('.date').datetimepicker({
                    locale: 'es',
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            });
        }]);
    </script>
@endsection