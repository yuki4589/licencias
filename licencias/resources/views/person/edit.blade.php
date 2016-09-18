@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Persona {{ $person->first_name }} {{ $person->last_name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('person.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('person.show', ['id' => $person->id]) }}" role="button">Volver a la persona</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($person, array('route' => array('person.update', $person->id), 'method' => 'put')) !!}

                @include('person.fields')
            
                {!! Form::button('Guardar cambios en la Persona ' . $person->first_name . " " . $person->last_name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
