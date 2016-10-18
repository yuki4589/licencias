<div class="form-group @if($errors->first('weight')) has-error @endif">
    {!! Form::label('weight', 'Orden de ejecución', ['class' => 'control-label']) !!}
    {!! Form::text('weight', null, ['class' => 'form-control', 'id' => 'weight_input', 'placeholder' => 'Orden de ejecución']) !!}
</div>

<div class="form-group @if($errors->first('days')) has-error @endif">
    {!! Form::label('days', 'Días', ['class' => 'control-label']) !!}
    {!! Form::text('days', null, ['class' => 'form-control', 'id' => 'days_input', 'placeholder' => 'Días']) !!}
</div>

<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Nombre']) !!}
</div>

<div class="form-group @if($errors->first('days')) has-error @endif">
    {!! Form::label('code', 'Código', ['class' => 'control-label']) !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code_input', 'placeholder' => 'Código']) !!}
</div>