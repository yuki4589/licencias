@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Denuncias
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('denunciation.create') }}" role="button">Dar de Alta una denuncia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de las {{ $amount }} denuncias actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Licencia</th>
                    <th>Fecha de registro</th>
                    <th>Número de expediente</th>
                    <th>Razón</th>
                    @if(env('FILE_UPLOAD'))
                        <th>Fichero</th>
                    @endif
                </tr>
            @foreach($denunciations as $denunciation)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('denunciation.show', ['id' => $denunciation->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('denunciation.edit', ['id' => $denunciation->id]) }}" role="button">Editar</a></td>
                    <td>{{ $denunciation->license->id }}</td>
                    <td>{{ $denunciation->register_date_output }}</td>
                    <td>{{ $denunciation->expedient_number }}</td>
                    <td>
                        @if($denunciation->reason)
                            {{ $denunciation->reason }}
                        @endif
                    </td>
                    @if(env('FILE_UPLOAD'))
                        <td><a href="{{ route('file.download', ['file' => $denunciation->file->id]) }}" target="_blank">Descargar {{ $denunciation->file->filename }}</a></td>
                    @endif
                </tr>
                @endforeach
            </table>

            {!! $denunciations->render() !!}
        </div>
    </div>
@endsection