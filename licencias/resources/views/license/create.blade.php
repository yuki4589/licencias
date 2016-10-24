@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Alta de licencias
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('license.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body" ng-app="licenseApp" ng-controller="licenseController" ng-cloak>

            @include('errors.form')

            {!! Form::open(array('route' => 'license.store', 'method' => 'post', 'class' => 'prueba', 'autocomplete' => 'off')) !!}
                @include('license.fields')
                <a  ng-click="validaLicencia()" class="btn btn-warning">Crear licencia</a>
            {!! Form::close() !!}
            @include('license.exposed.modalExpire')
        </div>
    </div>
@endsection

@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('licenseController', ['$scope', '$http', function ($scope, $http) {
            $scope.commerce_name = ""; //se agrega al scope el campo de "nombre del comercio"
            $scope.variable;
            $scope.activitySearch = function () {
                $scope.activity_id = null;
                $http.get('../activity/search/' + $scope.activity_name).then(pushActivities);
            };

            /*
            * Llama al servicio que valida si hay una licencia con
            * la dirección que se esta ingresando 
            */
            $scope.validaLicencia = function(){
                $scope.validaStreet = {};
                $scope.validaStreet.street_id = $scope.street_id;
                $scope.validaStreet.street_number = $scope.street_number;
                $http.post('../validalicencia', $scope.validaStreet)
                .then(function (response) {
                    $scope.variable = response.data;
                    if ($scope.variable.data) {
                        $('#expedient_number').text($scope.variable.expedient_number);
                        $('#register_number').text($scope.variable.register_number);
                        $('#commerce_name').text($scope.variable.commerce_name);
                        $('#titular').text($scope.variable.titular);
                        $('#modal-caducidad').modal('show');
                    } else {
                        $('.prueba').submit();
                    }
                    
                });
            }

            /**/
            $scope.caducarlicencia = function () {
                swal({
                    title: "Inicio de proceso",
                    text: "Desea iniciar el proceso para caducar la licencia?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Iniciar proceso",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $http.get('../caducarlicense/' + $scope.variable.license_id)
                        .success(function (data) {
                            swal("Se ha iniciado el proceso para caducar la licencia");
                            window.location.href = '../expire';
                        });
                        
                    } else {
                        $('#modal-caducidad').modal('hide');
                    }
                });
                
                //$scope.activity_id = null;
            };

            function pushActivities(response) {
                $scope.activities = response.data.activities;
            }

            $scope.activitySelect = function () {
                $scope.activity_name = this.activity.name;
                $scope.activity_id = this.activity.id;
                $scope.activities = {};
            };

            $scope.streetSearch = function () {
                $scope.street_id = null;
                $http.get('../street/search/' + $scope.street_name).then(pushStreets);
            };

            function pushStreets(response) {
                $scope.streets = response.data.streets;
            }

            $scope.streetSelect = function () {
                $scope.street_name = this.street.name;
                $scope.street_id = this.street.id;
                $scope.streets = {};
            };

            $scope.titularSearch = function () {
                $scope.titular_id = null;
                $scope.titular_first_name = null;
                $scope.titular_last_name = null;
                $scope.titular_phone_number = null;
                $scope.titular_email = null;
                $http.get('../titular/search/' + $scope.titular_nif).then(pushTitulars);
            };

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