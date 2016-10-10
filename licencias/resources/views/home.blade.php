@extends('layout')

@section('content')
<div ng-app="licenseApp" ng-controller="licenseController" ng-cloak>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="js-slider" data-slider-dots="true" data-slider-arrows="true" data-slider-autoplay="true">
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-book-open fa-2x"></i>
                            <div class="h1 font-w700">{{ $activityCommunicationAmount }}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Comunicados de actividad</div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-danger text-white">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-book-open fa-2x"></i>
                            <div class="h1 font-w700">{{ $withQualificationAmount }}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Licencias con calificación</div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-warning text-white">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-book-open fa-2x"></i>
                            <div class="h1 font-w700">{{ $withoutQualificationAmount }}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Licencias sin calificación</div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-primary text-white">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="js-slider" data-slider-dots="true" data-slider-arrows="true" data-slider-autoplay="true">
                
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-bell fa-2x"></i>
                            <div class="h1 font-w700">{{$typeAlert}}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Reparos</div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-danger text-white">
                    </div>
                </div>
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-bell fa-2x"></i>
                            <div class="h1 font-w700">{{$typeAlert3}}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Creacion manual</div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-warning text-white">
                    </div>
                </div>
                <div>
                    <div class="block text-center remove-margin-b">
                        <div class="block-content block-content-full">
                            <i class="si si-bell fa-2x"></i>
                            <div class="h1 font-w700">{{$typeAlert2}}</div>
                            <div class="h5 text-muted text-uppercase push-5-t">Plazo de espera</div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-mini bg-primary text-white">
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="block">
            <div class="block-header">
                <h3 class="page-heading">Licencias - Expedientes abiertos</h3>
            </div>
            <div class="block-content">
                <nit-advanced-searchbox
                    ng-model="searchParams"
                    parameters="availableSearchParams"
                    placeholder="Buscar...">
                </nit-advanced-searchbox>
                <table class="table table-striped table-hover table-header-bg">
                    <thead>
                        <tr>
                            <th>Nº expediente</th>
                            <th>Actividad</th>
                            <th>Dirección</th>
                            <th>Titular</th>
                            <th>Tipo</th>
                            <th>Fecha Último cambio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-dir-paginate="license in licenses | orderBy:sortKey:reverse | filter:searchParams |itemsPerPage:15">
                            <td>@{{ license.expedient_number }}</td>
                            <td>@{{ license.activity_name }}</td>
                            <td>@{{ license.street.name }}, @{{ license.street_number}} </td>
                            <td>@{{ license.titular.first_name }} @{{ license.titular.last_name }}</td>
                            <td>
                                @{{ license.type }}
                            </td>
                            <td>
                                @{{ license.updated_at }}
                            </td>
                           {{-- <td>
                                 @if (isset($license->license_data_current_stage))
                                     @{{ $license->license_data_current_stage->updated_at }}
                                 @endif
                             </td>--}}
                             <td>
                                 <a class="btn btn-warning"
                                    href="license/@{{ license.id }}" role="button">Ver</a>
                             </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <dir-pagination-controls
                            max-size="15"
                            direction-links="true"
                            boundary-links="true" >
                    </dir-pagination-controls>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="block">
                <div class="block-header">
                    <h3 class="page-heading">Cambios de titularidad</h3>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-hover table-header-bg">
                        <thead>
                            <tr>
                                <th>Licencia</th>
                                <th>Titular</th>
                                <th>Número de Expediente</th>
                                <th>Número de registro</th>
                                <th>Fecha de registro</th>
                                <th>Fecha de finalización</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($titularityChanges as $titularityChange)
                                <tr>
                                    <td>{{ $titularityChange->license->number }}
                                        /{{ $titularityChange->license->year }} {{ $titularityChange->license->licenseType->name }}</td>
                                    <td>{{ $titularityChange->titular->first_name }} {{ $titularityChange->titular->last_name }}</td>
                                    <td>{{ $titularityChange->expedient_number }}</td>
                                    <td>{{ $titularityChange->register_number }}</td>
                                    <td>{{ $titularityChange->register_date_output }}</td>

                                    @if (isset($titularityChange->finished_date_output))
                                        <td>{{ $titularityChange->finished_date_output }}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if (isset($titularityChange->status))
                                        <td>{{ $titularityChange->status }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        <a class="btn btn-warning"
                                           href="{{ route('titularitychange.show', ['id' => $titularityChange->id]) }}"
                                           role="button">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $titularityChanges->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts_at_head')
@endsection

@section('scripts_at_body')
    <script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload',
            'ui.bootstrap',
            'angular-advanced-searchbox',
            'angularUtils.directives.dirPagination']);

        licenseApp.controller('licenseController', ['$scope', '$http', function ($scope, $http) {

            $scope.getAllActivities = [];
            $scope.getAllStreets = [];
            $scope.nifs = [];
            $scope.status = [];
            $scope.types = [];
            $scope.allTypes = [];

            $http.get('api/v1/getAllLicenseType')
            .success(function (response){
                $scope.allTypes = response.data;
                angular.forEach(response.data, function(value, key) {
                    $scope.types.push(value.name);
                });
            });

            $http.get('api/v1/getAllLicenseStatus')
            .success(function (response){
                angular.forEach(response.data, function(value, key) {
                    $scope.status.push(value.name);
                });
            });

            $http.get('api/v1/getAllStreets')
            .success(function (response){
                angular.forEach(response.data, function(value, key) {
                    $scope.getAllStreets.push(value.name);
                });
            });

            $http.get('api/v1/getAllActivities')
            .success(function (response){
                angular.forEach(response.data, function(value, key) {
                    $scope.getAllActivities.push(value.name);
                });
            });

            $http.get('api/v1/getlicenses')
            .success(function (response){
                $scope.licenses = response.data;
                angular.forEach($scope.licenses, function(value, key) {
                    $scope.nifs.push(value.titular.nif);
                    value.nif = value.titular.nif;
                    value.activity_name = value.activity.name;
                    value.street_name = value.street.name;
                    value.status = value.license_status.name;
                    angular.forEach($scope.allTypes, function(value2, key2) {
                        if(value2.id == value.license_type_id){
                            value.type = value2.name;
                        }
                    });
                });
                $scope.searchParams.status = 'Solicitada';
            });

            // Fileds for search in user model
            $scope.availableSearchParams = [
                { key: "status", name: "Estado", placeholder: "Estado..."  ,  restrictToSuggestedValues: true, suggestedValues: $scope.status},
                { key: "type", name: "Tipos de licencias", placeholder: "Tipos de licencaias..."  ,  restrictToSuggestedValues: true, suggestedValues: $scope.types},

                { key: "expedient_number", name: "No expediente", placeholder: "Nº expediente..." },
                { key: "register_number", name: "No de registro", placeholder: "No de registro..." },
                { key: "identifier", name: "No de licencia", placeholder: "No de licencia..."},
                { key: "nif", name: "NIF", placeholder: "NIF...", restrictToSuggestedValues: true, suggestedValues: $scope.nifs },
                { key: "activity_name", name: "Actividad", placeholder: "Actividad...", restrictToSuggestedValues: true, suggestedValues: $scope.getAllActivities },
                { key: "street_name", name: "Dirección", placeholder: "Dirección..." , restrictToSuggestedValues: true, suggestedValues: $scope.getAllStreets  },
                { key: "commerce_name", name: "Nombre Comercial" , placeholder: "Nombre Comercial..." },
            ];




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