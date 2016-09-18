@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    Regístrate
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            <form method="POST" action="/auth/register">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="name" class="control-label">Nombre</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">Correo electrónico</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="control-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password">
                </div>

                <div class="form-group">
                    <button type="submit">Regístrate</button>
                </div>
            </form>
        </div>
    </div>
@endsection
