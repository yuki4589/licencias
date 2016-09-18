@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Tipos de usuario
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('usertype.create') }}" role="button">Dar de Alta un tipo de usuario</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} tipos de usuarios actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Tipos de usuario</th>
                </tr>
            @foreach($userTypes as $userType)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('usertype.show', ['id' => $userType->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('usertype.edit', ['id' => $userType->id]) }}" role="button">Editar</a></td>
                    <td>{{ $userType->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $userTypes->render() !!}
        </div>
    </div>
@endsection

