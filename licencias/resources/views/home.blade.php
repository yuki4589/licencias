@extends('layout')

@section('sidebar')
        <h3>Filtro</h3>
        {!! Form::open([
            'route' => [
                'home'
            ],
            'method' => 'get',
            'autocomplete' => 'off'
            ]
            ) !!}
        <div ng-app="licenseApp" ng-controller="licenseController">
            <div class="form-group">
                {!! Form::label('license_type_id', 'Tipo Licencia', ['class' => 'control-label']) !!}
                {!! Form::select('license_type_id', $licenseTypes, $licenseTypeId, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo de licencia...']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('license_status_id', 'Estado', ['class' => 'control-label']) !!}
                {!! Form::select('license_status_id', $licenseStatuses, $licenseStatusId, ['class' => 'form-control', 'placeholder' => 'Selecciona un estado de licencia...']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('expedient_number', 'Nº de expediente', ['class' => 'control-label']) !!}
                {!! Form::text('expedient_number', $expedientNumber) !!}
            </div>

            <div class="form-group">
                {!! Form::label('register_number', 'Nº de registro', ['class' => 'control-label']) !!}
                {!! Form::text('register_number', $registerNumber) !!}
            </div>

            <div class="form-group">
                {!! Form::label('license_identifier', 'Nº licencia', ['class' => 'control-label']) !!}
                {!! Form::text('license_identifier', $licenseIdentifier) !!}
            </div>

            <div class="form-group">
                {!! Form::label('titular_nif', 'NIF/CIF', ['class' => 'control-label']) !!}
                {!! Form::text('titular_nif', $titularNif) !!}
            </div>

            <div class="form-group">
                {!! Form::label('titular_first_name', 'Nombre', ['class' => 'control-label']) !!}
                {!! Form::text('titular_first_name', $titularFirstName) !!}
            </div>

            <div class="form-group">
                {!! Form::label('titular_last_name', 'Apellidos', ['class' => 'control-label']) !!}
                {!! Form::text('titular_last_name', $titularLastName) !!}
            </div>

            <div class="form-group">
                {!! Form::label('activity_id', 'Actividad', ['class' => 'control-label']) !!}
                {!! Form::hidden('activity_id', null, ['class' => 'form-control', 'ng-value' => 'activity_id']) !!}
                {!! Form::text('activity_name', null, ['class' => 'form-control', 'ng-change' => 'activitySearch()', 'ng-model' => 'activity_name', 'ng-init' => 'activity_name="' . $activityName . '"']) !!}
                <div class="list-group" ng-show="activities.length">
                    <button type="button" class="list-group-item" ng-click="activitySelect()" ng-repeat="activity in activities">
                        @{{ activity.name }}
                    </button>
                </div>
                {{--!! Form::label('activityId', 'Actividad', ['class' => 'control-label']) !!--}}
                {{--!! Form::select('activityId', $activities, $activityId, ['class' => 'form-control', 'placeholder' => 'Selecciona una actividad...']) !!--}}
            </div>

            <div class="form-group">
                {!! Form::label('street_id', 'Vía', ['class' => 'control-label']) !!}
                {!! Form::hidden('street_id', null, ['class' => 'form-control', 'ng-value' => 'street_id']) !!}
                {!! Form::text('street_name', null, ['class' => 'form-control', 'ng-change' => 'streetSearch()', 'ng-model' => 'street_name', 'ng-init' => 'street_name="' . $streetName . '"']) !!}
                <div class="list-group" ng-show="streets.length">
                    <button type="button" class="list-group-item" ng-click="streetSelect()" ng-repeat="street in streets">
                        @{{ street.name }}
                    </button>
                </div>
                {{--!! Form::label('street', 'Calle', ['class' => 'control-label']) !!--}}
                {{--!! Form::text('street', $street) !!--}}
            </div>

            <div class="form-group">
                {!! Form::label('street_number', 'Número', ['class' => 'control-label']) !!}
                {!! Form::text('street_number', $streetNumber) !!}
            </div>

            <div class="form-group">
                {!! Form::checkbox('filter_by_register_date', 'filter_by_register_date', $filterByRegisterDate) !!} Filtrar por fecha de registro
            </div>
            <div class="form-group">
                {!! Form::label('register_initial_date', 'Fecha Inicial Registro', ['class' => 'control-label']) !!}
                {!! Form::date('register_initial_date', $registerInitialDate) !!}
            </div>
            <div class="form-group">
                {!! Form::label('register_final_date', 'Fecha Final Registro', ['class' => 'control-label']) !!}
                {!! Form::date('register_final_date', $registerFinalDate) !!}
            </div>

            <div class="form-group">
                {!! Form::button('Filtrar', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}

@endsection

@section('content')
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-4 home-notification bg-success">
            <ul class="bxslider">
                <li>
                    <h3><a href="?license_type_id=1">Comunicados de actividad</a></h3>
                    <h4><a href="?license_type_id=1">{{ $activityCommunicationAmount }}</a></h4>
                </li>
                <li>
                    <h3><a href="?license_type_id=3">Licencias con calificación</a></h3>
                    <h4><a href="?license_type_id=3">{{ $withQualificationAmount }}</a></h4>
                </li>
                <li>
                    <h3><a href="?license_type_id=2">Licencias sin calificación</a></h3>
                    <h4><a href="?license_type_id=2">{{ $withoutQualificationAmount }}</a></h4>
                </li>
                <li>
                    <h3>Cambios de titularidad</h3>
                    <h4>{{ $titularityChangesAmount }}</h4>
                </li>
            </ul>
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-4 home-notification bg-danger">
            <div class="row">
                <div class="col-md-4">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true" style="font-size:6em;top:20px;"></span>
                </div>
                <div class="col-md-8 text-left">
                    <h3>Alertas</h3>
                    <h4>ALERTAS</h4>
                </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 yellow">
            <div class="row">
                <div class="col-md-12">
                    <h2>Expedientes abiertos</h2>
                    <h3>Licencias</h3>

                    <table class="table">
                        <tr>
                            <th></th>
                            <!--
                            <th>ID</th>
                            <th>Número de registro</th>
                            -->
                            <th>Nº expediente</th>
                            <th>Actividad</th>
                            <th>Dirección</th>
                            <th>Titular</th>
                            <th>Último cambio</th>
                            <th>Fecha Último cambio</th>
                        </tr>
                        @foreach($licenses as $license)
                            <tr>
                                <td>
                                    <a class="btn btn-warning"
                                       href="{{ route('license.show', ['id' => $license->id]) }}" role="button">Ver</a>
                                </td>
                                <!--
                                <td>#{{ $license->id }}</td>
                                <td>{{ $license->register_number }}</td>
                                -->
                                <td>{{ $license->expedient_number }}</td>
                                <td>{{ $license->activity->name }}</td>
                                <td>{{ $license->street->name }}, {{ $license->street_number}} </td>
                                <td>{{ $license->titular->first_name }} {{ $license->titular->last_name }}</td>
                                <td>
                                    @if(isset($license->current_stage->name))
                                        {{ $license->current_stage->name }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($license->license_data_current_stage))
                                        {{ $license->license_data_current_stage->updated_at }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $licenses->appends([
                        'expedient_number' => $expedientNumber,
                        'register_number' => $registerNumber,
                        'license_identifier' => $licenseIdentifier,
                        'titular_nif' => $titularNif,
                        'titular_first_name' => $titularFirstName,
                        'titular_last_name' => $titularLastName,
                        'street_id' => $streetId,
                        'street_name' => $streetName,
                        'street_number' => $streetNumber,
                        'activity_id' => $activityId,
                        'activity_name' => $activityName,
                        'license_type_id' => $licenseTypeId,
                        'license_status_id' => $licenseStatusId,
                        'filter_by_register_date' => $filterByRegisterDate,
                        'register_initial_date' => $registerInitialDate,
                        'register_final_date' => $registerFinalDate,
                    ])->render() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Cambios de titularidad</h2>
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>Licencia</th>
                            <th>Titular</th>
                            <th>Número de Expediente</th>
                            <th>Número de registro</th>
                            <th>Fecha de registro</th>
                            <th>Fecha de finalización</th>
                            <th>Estado</th>
                        </tr>
                        @foreach($titularityChanges as $titularityChange)
                            <tr>
                                <td>
                                    <a class="btn btn-warning"
                                       href="{{ route('titularitychange.show', ['id' => $titularityChange->id]) }}"
                                       role="button">Ver</a>
                                </td>
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
                            </tr>
                        @endforeach
                    </table>

                    {!! $titularityChanges->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_at_head')
    <link href="{{ asset('lib/jquery.bxslider.css') }}" rel="stylesheet" />
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
    <script src="{{ asset('js/jquery.bxslider.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                controls: false
            });
        });
    </script>
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