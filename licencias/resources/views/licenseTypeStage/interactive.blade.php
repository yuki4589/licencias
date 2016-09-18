@extends('layout')

@section('scripts_at_head')
    <style>
        .list {
            list-style: none outside none;
            margin: 10px 0 30px;
        }

        .apps-container {
            border: 2px dashed blue;
            margin: 10px 10px 0 0;
            padding: 5px;
            min-width:200px;
            min-height:50px;
        }

        .app {
            width: 170px;
            padding: 5px 10px;
            margin: 5px 0;
            border: 2px solid #444;
            border-radius: 5px;
            background-color: #EA8A8A;

            font-size: 1.1em;
            font-weight: bold;
            text-align: center;
            cursor: move;
        }

        .logList {
            margin-top: 20px;
            width: 250px;
            min-height: 300px;
            padding: 5px 15px;
            border: 5px solid #000;
            border-radius: 15px;
        }

        .logItem {
            margin-bottom: 10px;
        }

        .logList:before {
            content: 'log';
            padding: 0 5px;
            position: relative;
            top: -1.1em;
            background-color: #FFF;
        }

        .container {
            width: 750px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        .floatleft {
            float: left;
        }

        .floatright {
            float: right;
        }

        .clear {
            clear: both;
        }
    </style>
@endsection

@section('scripts_at_body')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload-shim.min.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload.min.js') }}"></script>
    <script src="{{ asset('js/sortable.js') }}"></script>
    <script>
        var myapp = angular.module('sortableApp', ['ui.sortable']);

        myapp.controller('sortableController', function ($scope, $http) {

            var tmpList = [];

            $scope.changeLicenseType = function() {
                if($scope.licenseType === ""){
                    $http.get('licensestagestojson').then(licenseStages);
                }
                else {
                    $http.get('licensestagestojson/licensetype/' + $scope.licenseType).then(licenseTypeStages);

                    function licenseTypeStages(response) {
                        $scope.allStages = response.data.allStages;
                        $scope.customStages = response.data.customStages;

                        $scope.rawLists = [
                            $scope.allStages,
                            $scope.customStages
                        ];

                        $scope.allStages = $scope.rawLists[0];
                        $scope.customStages = $scope.rawLists[1];
                    }
                }
            };

            $http.get('licensestagestojson').then(licenseStages);

            function licenseStages(response) {
                $scope.allStages = response.data;
                $scope.customStages = [];

                $scope.rawLists = [
                    $scope.allStages,
                    $scope.customStages
                ];

                $scope.allStages = $scope.rawLists[0];
                $scope.customStages = $scope.rawLists[1];
            };

            $scope.sortingLog = [];

            $scope.sortableOptions = {
                placeholder: "app",
                connectWith: ".apps-container",
                stop: function(e, ui) {
                    $http.put('licensestagestojson/licensetype/' + $scope.licenseType, $scope.customStages).then(putLicenseTypeStages);
                    function putLicenseTypeStages(response) {
                        $scope.sortingLog = [];
                        var logEntry = $scope.customStages.map(function(i){
                            return i.name;
                        }).join(', ');
                        $scope.sortingLog.push('Update: ' + logEntry);
                    };
                },
            };

            $scope.logModels = function () {
                $scope.sortingLog = [];
                for (var i = 0; i < $scope.rawLists.length; i++) {
                    var logEntry = $scope.rawLists[i].map(function (x) {
                        return x.name;
                    }).join(', ');
                    logEntry = 'container ' + (i+1) + ': ' + logEntry;
                    $scope.sortingLog.push(logEntry);
                }
            };
        });
    </script>
@endsection

@section('content')
    <div ng-app="sortableApp" ng-controller="sortableController" class="container">

        <h2>Creación de rutas</h2>

        <div class="floatleft">

            <div ui-sortable="sortableOptions" class="apps-container screen floatleft" ng-model="allStages">
                <div class="app" ng-repeat="stage in allStages">@{{$index}} @{{stage.name}}</div>
            </div>


            <div ui-sortable="sortableOptions" class="apps-container screen floatleft" ng-model="customStages">
                <div class="app" ng-repeat="stage in customStages">@{{$index}} @{{stage.name}}</div>
            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="floatright">
            <div class="form-group @if($errors->first('license_type_id')) has-error @endif">
                {!! Form::label('license_type_id', 'Tipo de Licencia', ['class' => 'control-label']) !!}
                {!! Form::select('license_type_id', $licenseTypes, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo de licencia...', 'ng-change' => 'changeLicenseType()', 'ng-model' => 'licenseType']) !!}
                licenseType = @{{ licenseType }}
            </div>

            <button type="button" ng-click="logModels()">Log Models</button>

            <ul class="list logList">
                <li ng-repeat="entry in sortingLog" class="logItem">
                    @{{entry}}
                </li>
            </ul>

        </div>

        <div class="clear"></div>
    </div>
@endsection



