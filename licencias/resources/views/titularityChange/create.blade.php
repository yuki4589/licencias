@extends('layout')

@section('content')
    <div ng-app="titularChangeApp" ng-controller="titularChangeController">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8">
                        Alta de Solicitud de Cambio de Titularidad
                        @if(isset($license))
                            para la Licencia {{ $license->number }}/{{ $license->year }}
                        @endif
                    </div>
                    <div class="col-md-4 text-right">
                        @if(isset($license))
                            <a class="btn btn-warning" href="{{ route('license.show', ['id' => $license->id]) }}" role="button">Volver a la licencia {{ $license->number }}/{{ $license->year }}</a>
                        @endif
                        <a class="btn btn-warning" href="{{ route('titularitychange.index') }}" role="button">Volver al listado</a>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                @include('errors.form')

                {!! Form::open(array('route' => 'titularitychange.store', 'files' => true, 'autocomplete' => 'off')) !!}

                    @include('titularityChange.fields')

                    <div class="text-center">
                        {!! Form::button('Crear Nuevo Cambio de Titularidad', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts_at_body')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload-shim.min.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload.min.js') }}"></script>
    <script src="{{ asset('js/sortable.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script>
        var titularChangeApp = angular.module('titularChangeApp', ['ngFileUpload']);

        titularChangeApp.controller('titularChangeController', ['$scope', '$http', function ($scope, $http) {
            $scope.titularSearch = function () {
                $scope.titular_id = null;
                $scope.titular_first_name = null;
                $scope.titular_last_name = null;
                $scope.titular_phone_number = null;
                $scope.titular_email = null;
                $http.get('../../../../titular/search/' + $scope.titular_nif).then(pushTitulars, getTitularFromLicense);
            };

            function getTitularFromLicense(response) {
                $http.get('../../titular/search/' + $scope.titular_nif).then(pushTitulars);
            }

            function pushTitulars(response) {
                $scope.titulars = response.data.titulars;
            }

            $scope.titularSelect = function () {
                $scope.titular_id = this.titular.id;
                $scope.titular_nif = this.titular.nif;
                $scope.titular_first_name = this.titular.first_name;
                $scope.titular_last_name = this.titular.last_name;
                $scope.titular_phone_number = this.titular.phone_number;
                $scope.titular_email = this.titular.email;
                $scope.titulars = {};
            };
        }]);
    </script>
@endsection