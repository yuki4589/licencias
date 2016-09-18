@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Alta de Estado de Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensestatus.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'licensestatus.store')) !!}

                @include('licenseStatus.fields')

                {!! Form::button('Crear Estado de Licencia', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
