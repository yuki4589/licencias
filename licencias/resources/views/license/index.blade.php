@extends('layout')

@section('pageTitle')
    Licencias
@endsection

@section('title')
    <div class="col-lg-12">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <i class="fa fa-book"></i> Licencias
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <a class="btn btn-success" href="{{ route('license.create') }}" role="button"><i class="fa fa-plus"></i> Alta de licencia</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="block">
            <div class="block-content">
                <table class="table table-striped table-hover table-header-bg js-dataTable-full">
                    <thead>
                        <tr>
                            <th>Registro interno</th>
                            <th>Nº licencia</th>
                            <th>Nº expediente</th>
                            <th>Estado</th>
                            <th>Titular</th>
                            <th>Actividad</th>
                            <th>Emplazamiento</th>
                            <th>Archivo</th>
                            <th>Armario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenses as $license)
                            <tr>
                                <td>{{ $license->register_number }}</td>
                                <td>{{ isset($license->identifier) ?  $license->identifier : '' }}</td>
                                <td>{{ $license->expedient_number }}</td>
                                <td>{{ $license->licenseStatus->name }}</td>
                                <td>{{ $license->titular->first_name }} {{ $license->titular->last_name }}</td>
                                <td>{{ $license->activity->name }}</td>
                                <td>{{ $license->street->name }}, {{ $license->street_number}} - {{ $license->city }} ({{ $license->postcode }})</td>
                                <td>{{ $license->volumeyear }}</td>
                                <td>{{ $license->closet }}</td>
                                <td><a class="btn btn-warning" href="{{ route('license.show', ['id' => $license->id]) }}" role="button">Ver</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">

                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('licenseController', ['$scope', '$http', function ($scope, $http) {
            $scope.activitySearch = function () {
                $scope.activity_id = null;
                $http.get('activity/search/' + $scope.activity_name).then(pushActivities);
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
                $http.get('street/search/' + $scope.street_name).then(pushStreets);
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
