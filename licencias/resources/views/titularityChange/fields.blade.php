@if(isset($license))
    {!! Form::hidden('license_id', $license->id, ['ng-model' => 'licenseId', 'ng-init' => 'licenseId=' . $license->id]) !!}
@elseif(isset($titularityChange))
    {!! Form::hidden('license_id', $titularityChange->license_id, ['ng-model' => 'licenseId', 'ng-init' => 'licenseId=' . $titularityChange->license_id]) !!}
@else
    <div class="panel panel-body panel-default">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group @if($errors->first('license_id')) has-error @endif">
                    {!! Form::label('license_id', 'Licencia', ['class' => 'control-label']) !!}
                    {!! Form::select('license_id', $licenses, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una licencia...', 'ng-model' => 'licenseId']) !!}
                </div>
            </div>
        </div>
    </div>
@endif
<div class="panel panel-body panel-default">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group @if($errors->first('register_number')) has-error @endif">
                {!! Form::label('register_number', 'Número de registro de entrada', ['class' => 'control-label']) !!}
                {!! Form::text('register_number', null, ['class' => 'form-control', 'id' => 'register_number_input', 'placeholder' => 'Número de registro']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group @if($errors->first('register_date')) has-error @endif">
                {!! Form::label('register_date', 'Fecha de registro', ['class' => 'control-label']) !!}
                @if(isset($titularityChange))
                    {!! Form::date('register_date', $titularityChange->register_date, ['class' => 'form-control']) !!}
                @else
                    {!! Form::date('register_date', \Carbon\Carbon::now(),  ['class' => 'form-control']) !!}
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group @if($errors->first('expedient_number')) has-error @endif">
                {!! Form::label('expedient_number', 'Número de expediente', ['class' => 'control-label']) !!}
                {!! Form::text('expedient_number', null, ['class' => 'form-control', 'id' => 'expedient_number_input', 'placeholder' => 'Número de expediente']) !!}
            </div>
        </div>
    </div>
</div>

@if(isset($titularityChange))
    {!! Form::hidden('titular_id', null, ['class' => 'form-control', 'ng-value' => 'titular_id', 'ng-init' => 'titular_id="' . $titularityChange->titular_id . '"']) !!}
@else
    {!! Form::hidden('titular_id', null, ['class' => 'form-control', 'ng-value' => 'titular_id']) !!}
@endif

<div class="panel panel-body panel-default">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group @if($errors->first('titular_nif')) has-error @endif">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {!! Form::label('titular_nif', 'NIF/CIF', ['class' => 'control-label']) !!}
                @if(isset($titularityChange))
                    @if($titularityChange->open)
                        {!! Form::text('titular_nif', null, ['class' => 'form-control', 'ng-change' => 'titularSearch()', 'ng-model' => 'titular_nif', 'ng-init' => 'titular_nif="' . $titularityChange->titular_nif . '"']) !!}
                    @else
                        {{ $titularityChange->titular_nif }}
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
                @if(isset($titularityChange))
                    @if($titularityChange->open)
                        {!! Form::text('titular_first_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'ng-model' => 'titular_first_name', 'ng-init' => 'titular_first_name="' . $titularityChange->titular_first_name . '"']) !!}
                    @else
                        {{ $titularityChange->titular_first_name }}
                    @endif
                @else
                    {!! Form::text('titular_first_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'ng-model' => 'titular_first_name']) !!}
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group @if($errors->first('titular_last_name')) has-error @endif">
                {!! Form::label('titular_last_name', 'Apellidos', ['class' => 'control-label']) !!}
                @if(isset($titularityChange))
                    @if($titularityChange->open)
                        {!! Form::text('titular_last_name', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'ng-model' => 'titular_last_name', 'ng-init' => 'titular_last_name="' . $titularityChange->titular_last_name . '"']) !!}
                    @else
                        {{ $titularityChange->titular_last_name }}
                    @endif
                @else
                    {!! Form::text('titular_last_name', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'ng-model' => 'titular_last_name']) !!}
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if($errors->first('titular_phone_number')) has-error @endif">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> {!! Form::label('titular_phone_number', 'Número de teléfono', ['class' => 'control-label']) !!}
                @if(isset($titularityChange))
                    @if($titularityChange->open)
                        {!! Form::text('titular_phone_number', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'ng-model' => 'titular_phone_number', 'ng-init' => 'titular_phone_number="' . $titularityChange->titular_phone_number . '"']) !!}
                    @else
                        {{ $titularityChange->titular_phone_number }}
                    @endif
                @else
                    {!! Form::text('titular_phone_number', null, ['class' => 'form-control', 'placeholder' => 'Teléfono', 'ng-model' => 'titular_phone_number']) !!}
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if($errors->first('titular_email')) has-error @endif">
                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {!! Form::label('titular_email', 'Correo electrónico', ['class' => 'control-label']) !!}
                @if(isset($titularityChange))
                    @if($titularityChange->open)
                        {!! Form::text('titular_email', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico', 'ng-model' => 'titular_email', 'ng-init' => 'titular_email="' . $titularityChange->titular_email . '"']) !!}
                    @else
                        {{ $titularityChange->titular_email }}
                    @endif
                @else
                    {!! Form::text('titular_email', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico', 'ng-model' => 'titular_email']) !!}
                @endif
            </div>
        </div>
    </div>
</div>

@if(isset($titularityChange))
    @include('file.exposed.fields')
@endif