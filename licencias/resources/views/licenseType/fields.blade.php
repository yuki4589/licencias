<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Tipo de Licencia', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name_input', 'placeholder' => 'Tipo de Licencia']) !!}
</div>

<div class="form-group @if($errors->first('description')) has-error @endif">
    {!! Form::label('description', 'Descripción', ['class' => 'control-label']) !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description_input', 'placeholder' => 'Descripción']) !!}
</div>

<div class="checkbox @if($errors->first('visit')) has-error @endif">
    <label>
        {!! Form::checkbox('visit', 'Visita') !!} Visita
    </label>
</div>