@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Alta de Posiciones de Persona
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('personposition.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'personposition.store')) !!}

                @include('personPosition.fields')

                {!! Form::button('Crear Posición de persona', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
