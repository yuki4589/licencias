<div ng-app="licenseApp" ng-controller="alertController" ng-cloak>
    <div class="panel panel-body panel-default">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @if($errors->first('title')) has-error @endif">
                {!! Form::label('title', 'Titulo', ['class' => 'control-label']) !!}
                @if(isset($objetoAlerta))
                    {!! Form::text('title', $objetoAlerta->title, ['class' => 'form-control', 'id' => 'title_input', 'placeholder' => 'Titulo']) !!}
                @else
                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title_input', 'placeholder' => 'Titulo']) !!}
                @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->first('date')) has-error @endif">
                    {!! Form::label('date', 'Fecha de publicación', ['class' => 'control-label']) !!}
                    @if(isset($objetoAlerta))
                        {!! Form::date('date', $objetoAlerta->date, ['class' => 'form-control']) !!}
                    @else
                        {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group @if($errors->first('license_id')) has-error @endif">
                    {!! Form::label('licence_id', 'Licencias', ['class' => 'control-label']) !!}
                    @if(isset($objetoAlerta))
                        {!! Form::select('license_id',  $licence, $objetoAlerta->license_id, ['class' => 'form-control', 'placeholder' => 'Selecciona una licencia...']) !!}
                    @else
                        {!! Form::select('license_id',  $licence, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una licencia...']) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('description', 'Descripción', ['class' => 'control-label']) !!}
                    @if(isset($objetoAlerta))
                        {!! Form::textarea('description', $objetoAlerta->description, ['class' => 'form-control', 'placeholder' => 'Descripción para la alerta']) !!}
                    @else
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descripción para la alerta']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>