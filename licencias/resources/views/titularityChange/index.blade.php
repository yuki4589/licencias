@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Cambios de Titularidad
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('titularitychange.create') }}" role="button">Dar de Alta una Solicitud de Cambio de Titularidad</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} cambios de titularidad actualmente en el sistema</p>

            <table class="table">
                <tr>
                    <th></th>
                    <!--
                    <th>Licencia</th>
                    <th>Titular</th>
                    -->
                    <th>Nº de Expediente</th>
                    <th>Estado</th>
                    <th>Antiguo Titular</th>
                    <th>Nuevo Titular</th>
                    <th>Actividad</th>
                    <th>Emplazamiento</th>
                    <!--
                    <th>Número de registro</th>
                    <th>Fecha de registro</th>
                    <th>Finalizado</th>
                    <th>Fecha de finalización</th>
                    @if(env('FILE_UPLOAD'))
                        <th>Fichero</th>
                    @endif
                    -->
                </tr>
            @foreach($titularityChanges as $titularityChange)
                <tr>
                    <td><a class="btn btn-warning" href="{{ route('titularitychange.show', ['id' => $titularityChange->id]) }}" role="button">Ver</a><!-- <a class="btn btn-warning" href="{{ route('titularitychange.edit', ['id' => $titularityChange->id]) }}" role="button">Editar</a>--></td>
                    <!--
                    <td>{{ $titularityChange->license->number }}/{{ $titularityChange->license->year }} {{ $titularityChange->license->licenseType->name }}</td>
                    <td>{{ $titularityChange->titular->first_name }} {{ $titularityChange->titular->last_name }}</td>
                    -->
                    <td>{{ $titularityChange->expedient_number }}</td>

                    @if (isset($titularityChange->status))
                        <td>{{ $titularityChange->status }}</td>
                    @else
                        <td></td>
                    @endif

                    <td>
                        @if(isset($titularityChange->lastTitular))
                            {{ $titularityChange->lastTitular->first_name}} {{ $titularityChange->lastTitular->last_name }}
                        @endif
                    </td>
                    <td>
                        {{ $titularityChange->titular->first_name }} {{ $titularityChange->titular->last_name }}
                    </td>

                    <td>
                        {{ $titularityChange->license->activity->name }}
                    </td>
                    <td>
                        {{ $titularityChange->license->street->name }} , {{ $titularityChange->license->street_number }} - {{ $titularityChange->license->postcode }} ({{ $titularityChange->license->city }})
                    </td>
                    <!--
                    <td>{{ $titularityChange->register_number }}</td>
                    <td>{{ $titularityChange->register_date_output }}</td>

                    @if (isset($titularityChange->finished))
                        <td>{{ $titularityChange->finished }}</td>
                    @else
                        <td></td>
                    @endif

                    @if (isset($titularityChange->finished_date_output))
                        <td>{{ $titularityChange->finished_date_output }}</td>
                    @else
                        <td></td>
                    @endif

                    @if(env('FILE_UPLOAD'))
                        @if (isset($titularityChange->file->filename))
                            <td><a href="{{ route('file.download', ['file' => $titularityChange->file->id]) }}" target="_blank">Descargar {{ $titularityChange->file->filename }}</a></td>
                        @else
                            <td></td>
                        @endif
                    @endif
                    -->
                </tr>
                @endforeach
            </table>

            {!! $titularityChanges->render() !!}
        </div>
    </div>
@endsection

