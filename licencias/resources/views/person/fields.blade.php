<div class="form-group @if($errors->first('first_name')) has-error @endif">
    {!! Form::label('first_name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name_input', 'placeholder' => 'Nombre']) !!}
</div>

<div class="form-group @if($errors->first('last_name')) has-error @endif">
    {!! Form::label('last_name', 'Apellidos', ['class' => 'control-label']) !!}
    {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name_input', 'placeholder' => 'Apellidos']) !!}
</div>

@include('personPosition.exposed.fields')

<div class="form-group @if($errors->first('email')) has-error @endif">
    {!! Form::label('email', 'Correo Electrónico', ['class' => 'control-label']) !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email_input', 'placeholder' => 'Correo Electrónico']) !!}
</div>
