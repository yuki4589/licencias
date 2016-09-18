<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Nombre del paso']) !!}
</div>
<div class="checkbox @if($errors->first('optional')) has-error @endif">
    <label>
        {!! Form::checkbox('optional', 'Paso Opcional') !!} Paso Opcional
    </label>
</div>
<div class="checkbox @if($errors->first('date')) has-error @endif">
    <label>
        {!! Form::checkbox('date', 'Campo Fecha') !!} Campo Fecha
    </label>
</div>

<div class="checkbox @if($errors->first('date_required')) has-error @endif">
    <label>
        {!! Form::checkbox('date_required', 'Campo Fecha Requerido') !!} Campo Fecha Requerido
    </label>
</div>

<div class="checkbox @if($errors->first('person')) has-error @endif">
    <label>
        {!! Form::checkbox('person', 'Campo Persona') !!} Campo Persona
    </label>
</div>

<div class="checkbox @if($errors->first('person_required')) has-error @endif">
    <label>
        {!! Form::checkbox('person_required', 'Campo Persona Requerido') !!} Campo Persona Requerido
    </label>
</div>

<div class="checkbox @if($errors->first('number')) has-error @endif">
    <label>
        {!! Form::checkbox('number', 'Campo Número') !!} Campo Número
    </label>
</div>

<div class="checkbox @if($errors->first('number_required')) has-error @endif">
    <label>
        {!! Form::checkbox('number_required', 'Campo Número Requerido') !!} Campo Número Requerido
    </label>
</div>

<div class="checkbox @if($errors->first('file')) has-error @endif">
    <label>
        {!! Form::checkbox('file', 'Campo Fichero') !!} Campo Fichero
    </label>
</div>

<div class="checkbox @if($errors->first('file_required')) has-error @endif">
    <label>
        {!! Form::checkbox('file_required', 'Campo Fichero Requerido') !!} Campo Fichero Requerido
    </label>
</div>

<div class="checkbox @if($errors->first('objection')) has-error @endif">
    <label>
        {!! Form::checkbox('objection', 'Campo Reparo') !!} Campo Reparo
    </label>
</div>

<div class="checkbox @if($errors->first('objection_required')) has-error @endif">
    <label>
        {!! Form::checkbox('objection_required', 'Campo Reparo Requerido') !!} Campo Reparo Requerido
    </label>
</div>