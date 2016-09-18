@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Estado de Licencia {{ $licenseStatus->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatus.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensestatus.show', ['id' => $licenseStatus->id]) }}" role="button">Volver al Estado de Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseStatus, array('route' => array('licensestatus.update', $licenseStatus->id), 'method' => 'put')) !!}

                @include('licenseStatus.fields')
            
                {!! Form::button('Guardar cambios en el Estado de Licencia ' . $licenseStatus->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
