@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar asociación entre paso y tipo de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetypestage.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensetypestage.show', ['id' => $licenseTypeStage->id]) }}" role="button">Volver a la asociación entre paso y tipo de Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseTypeStage, array('route' => array('licensetypestage.update', $licenseTypeStage->id), 'method' => 'put')) !!}

                @include('licenseTypeStage.fields')
            
                {!! Form::button('Guardar cambios', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
