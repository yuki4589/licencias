@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Cambio en el Estado de la Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.show', ['id' => $licenseStatusChange->id]) }}" role="button">Volver al Cambio en el Estado de la Licencia</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($licenseStatusChange, array('route' => array('licensestatuschange.update', $licenseStatusChange->id), 'method' => 'put')) !!}

                @include('licenseStatusChange.fields')
            
                {!! Form::button('Guardar Cambio en el Estado de la Licencia', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
