@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Alta de Cambio en el Estado de la Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatuschange.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'licensestatuschange.store')) !!}

                @include('licenseStatusChange.fields')

                {!! Form::button('Crear Cambio en el Estado de la Licencia', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
