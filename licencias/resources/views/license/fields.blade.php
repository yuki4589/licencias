<div ng-app="licenseApp" ng-controller="licenseController" ng-cloak>
    <div class="panel panel-body panel-default">
        <div class="row">
            <div class="col-md-6">
                @if(isset($license) && ! is_null($license->last_current_stage_id))
                    <div class="form-group @if($errors->first('license_type_id')) has-error @endif" style="padding-top:20px;">
                        <strong>Tipo de licencia:</strong> {{ $license->licenseType->name }}
                        {!! Form::hidden('license_type_id', $license->license_type_id) !!}
                    </div>
                @else
                    <div class="form-group @if($errors->first('license_type_id')) has-error @endif">
                        {!! Form::label('license_type_id', 'Tipo de Licencia', ['class' => 'control-label']) !!}
                        {!! Form::select('license_type_id', $licenseTypes, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo de licencia...']) !!}
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->first('expedient_number')) has-error @endif">
                    {!! Form::label('expedient_number', 'Número de expediente', ['class' => 'control-label']) !!}
                    {!! Form::text('expedient_number', null, ['class' => 'form-control', 'id' => 'expedient_number_input', 'placeholder' => 'Número de expediente']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @if($errors->first('register_number')) has-error @endif">
                    {!! Form::label('register_number', 'Número de registro', ['class' => 'control-label']) !!}
                    {!! Form::text('register_number', null, ['class' => 'form-control', 'id' => 'register_number_input', 'placeholder' => 'Número de registro']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->first('register_date')) has-error @endif">
                    {!! Form::label('register_date', 'Fecha de registro', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        {!! Form::date('register_date', $license->register_date, ['class' => 'form-control']) !!}
                    @else
                        {!! Form::date('register_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(isset($license->closet))
                    <div class="form-group @if($errors->first('closet')) has-error @endif">
                        {!! Form::label('closet', 'Armario', ['class' => 'control-label']) !!}
                        {!! Form::select('closet', $closets, $license->closet, ['class' => 'form-control', 'placeholder' => 'Selecciona un Armario...']) !!}
                    </div>
                @else
                    <div class="form-group @if($errors->first('closet')) has-error @endif">
                        {!! Form::label('closet', 'Armario', ['class' => 'control-label']) !!}
                        {!! Form::select('closet', $closets, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un Armario...']) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-body panel-default">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group @if($errors->first('activity_id')) has-error @endif">
                    {!! Form::label('activity_id', 'Actividad', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        {!! Form::hidden('activity_id', null, ['class' => 'form-control', 'ng-value' => 'activity_id', 'ng-init' => 'activity_id="' . $license->activity_id . '"']) !!}
                        {!! Form::text('activity_name', null, ['class' => 'form-control', 'ng-change' => 'activitySearch()', 'ng-model' => 'activity_name', 'ng-init' => 'activity_name="' . $license->activity_name . '"']) !!}
                    @else
                        {!! Form::hidden('activity_id', null, ['class' => 'form-control', 'ng-value' => 'activity_id']) !!}
                        {!! Form::text('activity_name', null, ['class' => 'form-control', 'ng-change' => 'activitySearch()', 'ng-model' => 'activity_name']) !!}
                    @endif
                    <div class="list-group" ng-show="activities.length">
                        <button type="button" class="list-group-item" ng-click="activitySelect()" ng-repeat="activity in activities">
                            @{{ activity.name }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group @if($errors->first('street_id')) has-error @endif">
                    {!! Form::label('street_id', 'Vía', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        {!! Form::hidden('street_id', null, ['class' => 'form-control', 'ng-value' => 'street_id', 'ng-init' => 'street_id="' . $license->street_id . '"']) !!}
                        {!! Form::text('street_name', null, ['class' => 'form-control', 'ng-change' => 'streetSearch()', 'ng-model' => 'street_name', 'ng-init' => 'street_name="' . $license->street_name . '"']) !!}
                    @else
                        {!! Form::hidden('street_id', null, ['class' => 'form-control', 'ng-value' => 'street_id']) !!}
                        {!! Form::text('street_name', null, ['class' => 'form-control', 'ng-change' => 'streetSearch()', 'ng-model' => 'street_name']) !!}
                    @endif
                    <div class="list-group" ng-show="streets.length">
                        <button type="button" class="list-group-item" ng-click="streetSelect()" ng-repeat="street in streets">
                            @{{ street.name }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group @if($errors->first('street_number')) has-error @endif">
                    {!! Form::label('street_number', 'Nº, piso, puerta', ['class' => 'control-label']) !!}
                    {!! Form::text('street_number', null, ['class' => 'form-control', 'id' => 'street_number_input', 'placeholder' => 'Introduce el número, piso, puerta...']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group @if($errors->first('postcode')) has-error @endif">
                    {!! Form::label('postcode', 'Código Postal', ['class' => 'control-label']) !!}
                    {!! Form::text('postcode', env('DEFAULT_POSTCODE'), ['class' => 'form-control', 'id' => 'postcode_input', 'placeholder' => 'Introduce el código postal...']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->first('city')) has-error @endif">
                    {!! Form::label('city', 'Municipio', ['class' => 'control-label']) !!}
                    {!! Form::text('city', env('DEFAULT_CITY'), ['class' => 'form-control', 'id' => 'city_input', 'placeholder' => 'Introduce la ciudad...']) !!}
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-body panel-default">
        @if(isset($license))
            {!! Form::hidden('titular_id', null, ['class' => 'form-control', 'ng-value' => 'titular_id', 'ng-init' => 'titular_id="' . $license->titular_id . '"']) !!}
        @else
            {!! Form::hidden('titular_id', null, ['class' => 'form-control', 'ng-value' => 'titular_id']) !!}
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="form-group @if($errors->first('titular_nif')) has-error @endif">
                    {!! Form::label('titular_nif', 'NIF/CIF', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        @if(is_null($license->identifier))
                            {!! Form::text('titular_nif', null, ['class' => 'form-control', 'ng-change' => 'titularSearch()', 'ng-model' => 'titular_nif', 'ng-init' => 'titular_nif="' . $license->titular_nif . '"']) !!}
                        @else
                            {{ $license->titular_nif }}
                        @endif
                    @else
                        {!! Form::text('titular_nif', null, ['class' => 'form-control', 'ng-change' => 'titularSearch()', 'ng-model' => 'titular_nif']) !!}
                    @endif
                    <div class="list-group" ng-show="titulars.length">
                        <button type="button" class="list-group-item" ng-click="titularSelect()" ng-repeat="titular in titulars">
                            @{{ titular.nif }} @{{ titular.first_name }} @{{ titular.last_name }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group @if($errors->first('titular_first_name')) has-error @endif">
                    {!! Form::label('titular_first_name', 'Nombre/Empresa', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        @if(is_null($license->identifier))
                            {!! Form::text('titular_first_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'ng-model' => 'titular_first_name', 'ng-init' => 'titular_first_name="' . $license->titular_first_name . '"']) !!}
                        @else
                            {{ $license->titular_first_name }}
                        @endif
                    @else
                        {!! Form::text('titular_first_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'ng-model' => 'titular_first_name']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group @if($errors->first('titular_last_name')) has-error @endif">
                    {!! Form::label('titular_last_name', 'Apellidos', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        @if(is_null($license->identifier))
                            {!! Form::text('titular_last_name', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'ng-model' => 'titular_last_name', 'ng-init' => 'titular_last_name="' . $license->titular_last_name . '"']) !!}
                        @else
                            {{ $license->titular_last_name }}
                        @endif
                    @else
                        {!! Form::text('titular_last_name', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'ng-model' => 'titular_last_name']) !!}
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group @if($errors->first('titular_email')) has-error @endif">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {!! Form::label('titular_email', 'Correo electrónico', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        @if(is_null($license->identifier))
                            {!! Form::text('titular_email', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico', 'ng-model' => 'titular_email', 'ng-init' => 'titular_email="' . $license->titular_email . '"']) !!}
                        @else
                            {{ $license->titular_email }}
                        @endif
                    @else
                        {!! Form::text('titular_email', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico', 'ng-model' => 'titular_email']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->first('titular_phone_number')) has-error @endif">
                    <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> {!! Form::label('titular_phone_number', 'Número de teléfono', ['class' => 'control-label']) !!}
                    @if(isset($license))
                        @if(is_null($license->identifier))
                            {!! Form::text('titular_phone_number', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'ng-model' => 'titular_phone_number', 'ng-init' => 'titular_phone_number="' . $license->titular_phone_number . '"']) !!}
                        @else
                            {{ $license->titular_phone_number }}
                        @endif
                    @else
                        {!! Form::text('titular_phone_number', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'ng-model' => 'titular_phone_number']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(isset($license))

        @include('archive.exposed.fields')

       <div class="form-group @if($errors->first('archive_location')) has-error @endif">
           {!! Form::label('archive_location', 'Localización en el Archivador', ['class' => 'control-label']) !!}
           {!! Form::text('archive_location', null, ['class' => 'form-control', 'id' => 'archive_location_input', 'placeholder' => 'Localización en el archivador']) !!}
       </div>

    @endif
</div>

