@extends('layout')

@section('pageTitle')
    Alertas
@endsection

@section('title')
    <div class="col-lg-12">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <i class="fa fa-bell"></i> Alertas
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <a class="btn btn-primary" href="{{ route('calendario') }}" role="button"><i class="fa fa-calendar"></i> Calendario</a>
            <a class="btn btn-success" href="{{ route('alert.create') }}" role="button"><i class="fa fa-plus"></i> Alta de alertas</a>
        </div>
    </div>
@endsection

@section('content')
<div ng-app="licenseApp" ng-controller="alertController" ng-cloak>
    <div class="row">
        <div class="block">
            <div class="block-content">
                <table class="table table-striped table-hover table-header-bg js-dataTable-full">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Fecha de publicación</th>
                            <th>Tipo de alerta</th>
                            <th>No. de expediente de licencia</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($alerts as $alert)
                            <tr>
                            	<input type="hidden" ng-model="idAlert" value="{{$alert['id']}}">
                                <td>{{ $alert['title'] }}</td>
                                <td>{{ $alert['description'] }}</td>
                                <td>{{ $alert['date'] }}</td>
                                <td>{{ $alert['type'] }}</td>
                                <td>{{ $alert['expedient_number']}}</td>
                                <td><a class="btn btn-warning" href="{{ route('alert.edit', ['id' => $alert['id']]) }}" role="button">Editar</a></td>
                                <td><a class="btn btn-danger" href="#" role="button" ng-click="deleteAlert({{$alert['id']}})">Eliminar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">

                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection


@section('scripts_at_body')
	<script>
        var licenseApp = angular.module('licenseApp', ['ngFileUpload']);

        licenseApp.controller('alertController', ['$scope', '$http', function ($scope, $http) {
        	$scope.idAlert;
            $scope.deleteAlert = function (id) {
            	console.log(id);
                swal({
                    title: "Eliminación de alertas",
                    text: "Desea eliminar esta alerta?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $http.delete('delete/alert/' + id)
                        .success(function (data) {
                            swal("Se eliminó con exito la alerta.");
                            window.location.reload();
                        }); 
                    }
                });
            };

            
        }]);
    </script>
@endsection