@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Archivadores
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('archive.create') }}" role="button">Dar de Alta un archivador</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} archivadores actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Actividad</th>
                </tr>
            @foreach($archives as $archive)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('archive.show', ['id' => $archive->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('archive.edit', ['id' => $archive->id]) }}" role="button">Editar</a></td>
                    <td>{{ $archive->name }}</td>
                </tr>
                @endforeach
            </table>

            {!! $archives->render() !!}
        </div>
    </div>
@endsection

