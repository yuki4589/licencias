@if(isset($licenses))
    <div class="form-group @if($errors->first('license_id')) has-error @endif">
        {!! Form::label('license_id', 'Licencia', ['class' => 'control-label']) !!}
        {!! Form::select('license_id', $licenses, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una licencia...', 'ng-model' => 'licenseId']) !!}
    </div>
@elseif(isset($license))
    {!! Form::hidden('license_id', $license->id, ['ng-model' => 'licenseId', 'ng-init' => 'licenseId=' . $license->id]) !!}
@endif