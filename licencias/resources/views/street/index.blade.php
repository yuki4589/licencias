@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Vías
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('street.create') }}" role="button">Dar de Alta una vía</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} vías actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Vía</th>
                </tr>
            @foreach($streets as $street)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('street.show', ['id' => $street->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('street.edit', ['id' => $street->id]) }}" role="button">Editar</a></td>
                    <td>{{ $street->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $streets->render() !!}
        </div>
    </div>
@endsection

