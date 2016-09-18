@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    Entra
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            <form method="POST" action="/auth/login">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div class="form-group">
                    <input type="checkbox" name="remember"> Recuérdame
                </div>

                <div class="form-group">
                    <button type="submit">Entra</button>
                </div>
            </form>
        </div>
    </div>
@endsection