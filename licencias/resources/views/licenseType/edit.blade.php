@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Tipo de Licencia {{ $licenseType->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensetype.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensetype.show', ['id' => $licenseType->id]) }}" role="button">Volver a Tipo de Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseType, array('route' => array('licensetype.update', $licenseType->id), 'method' => 'put')) !!}

                @include('licenseType.fields')
            
                {!! Form::button('Guardar cambios en el Tipo de Licencia ' . $licenseType->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
