@extends('layout')

@section('content')
<div ng-app="currentStageApp" ng-controller="currentStageController" ng-cloak>
   @include('licenseCurrentStage.interactive')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    Localización
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <label for="closet">Armario</label>
                        <span ng-hide="licenseClosetEdit">@{{ license.closet }}</span>
                        <span ng-hide="license.closet">Ninguno</span>
                        <span ng-show="licenseClosetEdit">
                            <select
                                    ng-model="license.closet"
                                    name="closet"
                                    ng-options="closet for closet in closets">
                            </select>
                        </span>
                        <button class="btn btn-warning" ng-click="licenseClosetEdit=true;license.closet = (license.closet === null ? 'A' : license.closet)" ng-hide="licenseClosetEdit">
                            Editar
                        </button>
                        <button class="btn btn-warning" ng-click="saveLicenseCloset()" ng-show="licenseClosetEdit">
                            Guardar Cambios
                        </button>
                        <button class="btn btn-danger" ng-click="deleteLicenseCloset()" ng-show="licenseClosetEdit">
                            Borrar dato
                        </button>
                    </p>
                    <div ng-show="license.finished">
                        <p>
                            <button class="btn btn-success" ng-click="licenseVolumeYearEdit=true" ng-hide="license.volume_year">
                                Archivar
                            </button>

                            <span ng-show="licenseVolumeYearEdit || license.volume_year">
                                <label for="volume_year">
                                    Tomo/Año
                                </label>
                                <span ng-hide="licenseVolumeYearEdit">@{{ license.volume_year }}</span>
                                <span ng-show="licenseVolumeYearEdit">
                                    <input name="volume_year" ng-model="license.volume_year">
                                </span>
                                <button
                                        class="btn btn-warning"
                                        ng-click="licenseVolumeYearEdit=true"
                                        ng-hide="licenseVolumeYearEdit">
                                    Editar
                                </button>
                                <button class="btn btn-success" ng-click="saveLicenseVolumeYear()" ng-show="licenseVolumeYearEdit">
                                    Guardar
                                </button>
                            </span>
                        </p>
                        <p>
                            <span ng-hide="license.on_query">
                                <button class="btn btn-danger" ng-click="saveLicenseOnQuery(true)" ng-hide="license.on_query">
                                    Consulta
                                </button>
                            </span>
                            <span ng-show="license.on_query">
                                <button class="btn btn-success" ng-click="saveLicenseOnQuery(false)" ng-show="license.on_query">
                                    Devolver a archivo
                                </button>
                            </span>
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-success" ng-click="licenseLoanEdit=true" ng-hide="licenseLoanEdit || license.on_loan">
                            Prestar
                        </button>

                        <span ng-show="licenseLoanEdit || license.on_loan">
                            <label for="loan_person" ng-hide="license.on_loan">
                                Prestar a
                            </label>
                            <label for="loan_person" ng-show="license.on_loan">
                                Prestado a
                            </label>

                            <span ng-hide="licenseLoanEdit">@{{ license.active_loan.person.first_name }} @{{ license.active_loan.person.last_name }} <span ng-show="license.active_loan.person.email"><@{{ license.active_loan.person.email }}></span></span>
                            <div ng-if="licenseLoanEdit">
                                <input type="hidden" name="person_id" id="active_loan_person_id" ng-model="license.active_loan.person.id">
                                <label for="first_name">
                                    Nombre:
                                </label>
                                <input type="text" name="first_name" id="active_loan_first_name" placeholder="Nombre" ng-model="license.active_loan.person.first_name" ng-init="autocompleteLoanPerson()">
                                <label for="last_name">
                                    Apellidos:
                                </label>
                                <input type="text" name="last_name" id="active_loan_last_name" placeholder="Apellidos" ng-model="license.active_loan.person.last_name">
                                <label for="email">
                                    Correo electrónico:
                                </label>
                                <input type="text" name="email" id="active_loan_email" placeholder="Correo Electrónico" ng-model="license.active_loan.person.email">

                                <div ng-show="license.active_loan.person.first_name && license.active_loan.person.last_name">
                                    <label for="loan_date">
                                        Fecha de préstamo
                                    </label>
                                    <input name="loan_date" type="date" ng-model="license.active_loan.loan_date" ng-init="license.active_loan.loan_date = formatDate(license.active_loan.loan_date)">

                                    <button class="btn btn-success" ng-click="savePersonDateActiveLoan()" ng-hide="licenseLoanDate || license.on_loan">
                                        Prestar
                                    </button>
                                    <div ng-show="licenseLoanDate || license.on_loan">
                                        <label for="giving_back_date">
                                            Fecha de devolución
                                        </label>
                                        <input name="giving_back_date" type="date" ng-model="license.active_loan.giving_back_date" ng-init="license.active_loan.giving_back_date = formatDate(license.active_loan.giving_back_date)">
                                        <button class="btn btn-warning" ng-click="closeActiveLoan()">
                                            Cerrar préstamo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="btn btn-warning"
                                ng-click="licenseLoanEdit=true"
                                ng-hide="licenseLoanEdit">
                                Editar
                            </button>
                            <button class="btn btn-success" ng-click="saveLicenseLoan()" ng-show="licenseLoanEdit && license.active_loan.person.first_name && license.active_loan.person.last_name">
                                Guardar
                            </button>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    {{ $license->licenseType->name }} {{ $license->number }}/{{ $license->year }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('license.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('license.edit', ['id' => $license->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist" id="license-tabs">
                <li role="presentation" class="active"><a href="#license-data" aria-controls="license-data" role="tab" data-toggle="tab">Datos</a></li>
                <li role="presentation"><a href="#license-details" aria-controls="license-details" role="tab" data-toggle="tab">Detalles</a></li>
                <li role="presentation"><a href="#license-titulars" aria-controls="license-titulars" role="tab" data-toggle="tab">Cambios de titularidad</a></li>
                <li role="presentation"><a href="#license-denunciations" aria-controls="license-denunciations" role="tab" data-toggle="tab">Denuncias</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active panel panel-body" id="license-data">
                    <!-- Datos -->
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Número de expediente:</strong> {{ $license->expedient_number }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Fecha de registro:</strong> {{ $license->register_date_output }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Número de registro:</strong> {{ $license->register_number }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Actividad:</strong> {{ $license->activity->name }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Dirección:</strong> {{ $license->street->name }} , {{ $license->street_number }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Código Postal:</strong> {{ $license->postcode }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Municipio:</strong> {{ $license->city }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <strong>Titular:</strong> {{ $license->titular->first_name }} {{ $license->titular->last_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>DNI/CIF:</strong> {{ $license->titular->nif }}</p>
                        </div>
                    </div>
                    <div class="row" style="border-top:1px solid lightgrey;padding-top:10px">
                        <div class="col-md-6">
                            @if(isset($license->titular->email))
                                <p><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <strong>Email:</strong> {{ $license->titular->email }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if(isset($license->titular->phone_number))
                                <p><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> <strong>Teléfono:</strong> {{ $license->titular->phone_number }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="border-top:1px solid lightgrey;padding-top:10px">
                        <div class="col-md-4">
                            <p><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> <strong>Nombre Archivador:</strong> {{ isset($license->archive->name) ? $license->archive->name : '' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Lugar Archivador:</strong> {{ isset($license->archive->place) ? $license->archive->place : '' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Localización Archivador:</strong> {{ isset($license->archive_location) ? $license->archive_location : '' }}</p>
                        </div>
                    </div>
                    <!-- <p><strong>Finalizado:</strong> {{ isset($license->finished) ?  $license->finished : '' }}</p>
                    <p><strong>Identificador licencia:</strong> {{ isset($license->identifier) ?  $license->identifier : '' }}</p>-->
                </div>
                <div role="tabpanel" class="tab-pane panel panel-body" id="license-details">
                    <!-- Detalles -->
                    @foreach($license->licenseCurrentStages as $currentStage)
                        <h3>{{$currentStage->licenseStage->name }}</h3>

                        @if(!empty($currentStage->date))
                            <p><strong>Fecha:</strong> {{  $currentStage->date_output }}</p>
                        @endif

                        @if(!empty($currentStage->person_id))
                            <p><strong>Persona:</strong> {{  $currentStage->person->full_name }}</p>
                        @endif

                        @if(!empty($currentStage->number))
                            <p><strong>Número:</strong> {{  $currentStage->number }}</p>
                        @endif

                        @if(env('FILE_UPLOAD'))
                            @if(!empty($currentStage->file_id))
                                <p><strong>Fichero:</strong> <a href="../file/download/{{ $currentStage->file_id }}" target="_blank">Descargar {{  $currentStage->file->filename }}</a></p>
                            @endif
                        @endif

                        @if(($currentStage->objections->count()) != 0)
                            <p><strong>Reparos</strong></p>

                            @foreach($currentStage->objections as $objection)
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-11">
                                <p><strong>Reparo {{ $objection->id }}</strong></p>
                                @if(!empty($objection->first_person_position_id))
                                    <p>Primera Posición de Persona: {{ $objection->firstPersonPosition->name }}</p>
                                @endif

                                @if(!empty($objection->second_person_position_id))
                                    <p>Segunda Posición de Persona: {{ $objection->firstPersonPosition->name }}</p>
                                @endif

                                @if(!empty($objection->report_date))
                                    <p>Fecha de reporte: {{ $objection->report_date_output }}</p>
                                @endif

                                @foreach($objection->objectionNotifications as $notification)
                                    <p>Notificación: {{ $notification->notification_date_output}} Fecha de Finalización: {{ $notification->finish_date_output }}</p>
                                @endforeach

                                @if(!empty($objection->correction_date))
                                    <p>Fecha de subsanación: {{ $objection->correction_date_output }}</p>
                                @endif
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <div role="tabpanel" class="tab-pane panel panel-body" id="license-titulars">
                    <!-- Cambios de titularidad -->
                    @if(! is_null($license->identifier))
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        Titulares para {{ $license->licenseType->name }} {{ $license->number }}/{{ $license->year }}
                                    </div>
                                    <div class="col-md-4 text-right">
                                        @if(! $license->titularity_change_active)
                                            <a class="btn btn-warning" href="{{ route('license.titularitychange', ['id' => $license->id]) }}" role="button">Nuevo Cambio de Titularidad</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @foreach($license->titularChanges as $titularChange)
                                <div class="panel-heading"
                                     @if($titularChange->status == "Solicitado")
                                        style="background-color: #f7ecb5;"
                                     @elseif($titularChange->status == "Desistido")
                                        style="background-color: #d9534f;"
                                     @else
                                        style="background-color: #dff0d8;"
                                     @endif
                                >
                                    <div class="row">
                                        <div class="col-md-2">
                                            <!--Solicitud {{ $titularChange->register_number }}-->
                                        </div>
                                        @if( ! $titularChange->finished)
                                            {!! Form::model($titularChange, array('route' => array('titularitychange.change', $titularChange->id), 'method' => 'put', 'files' => true, 'autocomplete' => 'off')) !!}
                                            <div class="col-md-10 text-right">
                                                <div class="col-md-4 text-right">
                                                    {!! Form::label('titular_change_date', 'Fecha del cambio de estado', ['class' => 'control-label']) !!}
                                                    {!! Form::date('titular_change_date', new \DateTime()) !!}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    {!! Form::label('titularChange_status', 'Selecciona una estado', ['class' => 'control-label']) !!}
                                                    {!! Form::select('titularChange_status', $titularChangeStatuses, $titularChange->status, ['class' => 'form-control', 'placeholder' => 'Selecciona un estado...', 'ng-change' => 'showChangeButton[' . $titularChange->id .'] = true', 'ng-model' => 'titular_change_date[' . $titularChange->id . ']', 'ng-init' => 'titular_change_date[' . $titularChange->id . '] = "' . $titularChange->status . '"']) !!}

                                                    {!! Form::button('Cambiar estado', ['class'=> 'btn btn-danger', 'type' => 'submit', 'ng-show' => 'showChangeButton[' . $titularChange->id .']']) !!}
                                                    {!! Form::close() !!}
                                                </div>

                                                <div class="col-md-2 text-right">
                                                    <a class="btn btn-warning" href="{{ route('license.titularitychange.edit', ['license_id' => $license->id, 'id' => $titularChange->id]) }}" role="button">Editar</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                <div class="panel panel-body panel-default">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p><strong>Número de registro de entrada:</strong> {{ $titularChange->register_number }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Fecha de registro:</strong> {{ $titularChange->register_date_output }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Número de expediente:</strong> {{ $titularChange->expedient_number }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(isset($titularChange->lastTitular))
                                                <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <strong>Anterior titular:</strong> {{ $titularChange->lastTitular->first_name}} {{ $titularChange->lastTitular->last_name }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <strong>Nuevo Titular:</strong> {{ $titularChange->titular->first_name }} {{ $titularChange->titular->last_name }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Estado:</strong> {{ isset($titularChange->status) ?  $titularChange->status : '' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            @if(isset($titularChange->finished_date_output) && $titularChange->finished_date_output != "")
                                            <p><strong>Fecha de finalización:</strong> {{ $titularChange->finished_date_output }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if(env('FILE_UPLOAD'))
                                        @if(isset($titularChange->file->filename))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p><strong>Fichero:</strong><a href="{{ route('file.download', ['file' => $titularChange->file->id]) }}">{{ $titularChange->file->filename }}</a></p>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div role="tabpanel" class="tab-pane panel panel-body" id="license-denunciations">
                    <!-- Denuncias -->
                    @if(! is_null($license->identifier))
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        Denuncias para {{ $license->licenseType->name }} {{ $license->number }}/{{ $license->year }}
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a class="btn btn-warning" href="{{ route('license.denunciation', ['id' => $license->id]) }}" role="button">Nueva Denuncia</a>
                                    </div>
                                </div>
                            </div>
                            @foreach($license->Denunciations as $denunciation)
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <a class="btn btn-warning" href="{{ route('denunciation.edit', ['id' => $denunciation->id]) }}" role="button">Editar</a>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Numero de expediente:</strong> {{ $denunciation->expedient_number }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Fecha de denuncia:</strong> {{ $denunciation->register_date_output }}
                                        </div>
                                        @if($denunciation->reason)
                                            <div class="col-md-5">
                                                <strong>Razón:</strong> {{$denunciation->reason}}
                                            </div>
                                        @endif
                                    </div>

                                    <hr>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    </div>
</div>
@endsection

@section('scripts_at_body')
    <script src="{{ asset('js/license/show.js') }}"></script>
@endsection

