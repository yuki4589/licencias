@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Posición {{ $personPosition->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('personposition.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('personposition.show', ['id' => $personPosition->id]) }}" role="button">Volver a Posición</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($personPosition, array('route' => array('personposition.update', $personPosition->id), 'method' => 'put')) !!}

                @include('personPosition.fields')
            
                {!! Form::button('Guardar cambios en la Posición ' . $personPosition->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
