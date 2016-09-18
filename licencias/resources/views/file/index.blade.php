@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Ficheros
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('file.create') }}" role="button">Dar de Alta un fichero</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} ficheros actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Fichero</th>
                </tr>
            @foreach($files as $file)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('file.show', ['id' => $file->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('file.edit', ['id' => $file->id]) }}" role="button">Editar</a></td>
                    <td><a href="{{ route('file.download', ['file' => $file->id]) }}" target="_blank">Descargar {{ $file->filename }}</a></td>
                </tr>
                @endforeach
            </table>

            {!! $files->render() !!}
        </div>
    </div>
@endsection

