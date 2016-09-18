@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Pasos de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestage.create') }}" role="button">Dar de Alta un Paso de Licencia</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <p>Listado completo de los {{ $amount }} pasos de licencia actualmente en el sistema</p>

            @foreach($licenseStages as $licenseStage)

                <h2><strong>Nombre: {{ $licenseStage->name }}</strong></h2>

                @if($licenseStage->optional)
                    <p><strong>Paso Opcional</strong></p>
                @endif

                <p><a class="btn btn-warning" href="{{ route('licensestage.show', ['id' => $licenseStage->id]) }}" role="button">Ver</a> <a class="btn btn-warning" href="{{ route('licensestage.edit', ['id' => $licenseStage->id]) }}" role="button">Editar</a></p>
                <p><strong>Campos:</strong></p>

                @if($licenseStage->date)
                   <p>Fecha
                   @if($licenseStage->date_required)
                       Requerido</p>
                   @else
                        Opcional</p>
                   @endif
                @endif

                @if($licenseStage->person)
                    <p>Persona
                    @if($licenseStage->person_required)
                        Requerido</p>
                    @else
                        Opcional</p>
                    @endif
                @endif

                @if($licenseStage->number)
                    <p>Número
                    @if($licenseStage->number_required)
                        Requerido</p>
                    @else
                        Opcional</p>
                    @endif
                @endif

                @if(env('FILE_UPLOAD'))
                    @if($licenseStage->file)
                        <p>Fichero
                        @if($licenseStage->file_required)
                            Requerido</p>
                        @else
                            Opcional</p>
                        @endif
                    @endif
                @endif

                @if($licenseStage->objection)
                    <p>Fichero
                    @if($licenseStage->objection_required)
                        Requerido</p>
                    @else
                        Opcional</p>
                    @endif
                @endif

                <p></p>
            @endforeach

            {!! $licenseStages->render() !!}
        </div>
    </div>
@endsection

