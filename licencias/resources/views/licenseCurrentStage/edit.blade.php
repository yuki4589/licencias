@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar etapa de la Licencia {{ $licenseCurrentStage->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.show', ['id' => $licenseCurrentStage->id]) }}" role="button">Volver a la etapa de Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseCurrentStage, array('route' => array('licensecurrentstage.update', $licenseCurrentStage->id), 'method' => 'put', 'files' => true)) !!}

                @include('licenseCurrentStage.fields')
            
                {!! Form::button('Guardar cambios', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
