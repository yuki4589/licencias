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

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'license.store', 'autocomplete' => 'off')) !!}
                @include('license.fields')
                {!! Form::button('Crear licencia', ['class'=> 'btn btn-warning', 'type' => 'submit', 'ng-model' => 'activityInput']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('licenseController', ['$scope', '$http', function ($scope, $http) {
            $scope.commerce_name = ""; //se agrega al scope el campo de "nombre del comercio"
            $scope.activitySearch = function () {
                $scope.activity_id = null;
                $http.get('../activity/search/' + $scope.activity_name).then(pushActivities);
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