@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Tipo de usuario {{ $userType->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('usertype.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('usertype.edit', ['id' => $userType->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Tipo de usuario:</strong> {{ $userType->name }}</p>
        </div>
    </div>
@endsection

