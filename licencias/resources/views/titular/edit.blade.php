@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Titular {{ $titular->first_name }} {{ $titular->last_name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('titular.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('titular.show', ['id' => $titular->id]) }}" role="button">Volver al titular</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($titular, array('route' => array('titular.update', $titular->id), 'method' => 'put')) !!}

                @include('titular.fields')
            
                {!! Form::button('Guardar cambios en el Titular ' . $titular->first_name . " " . $titular->last_name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
