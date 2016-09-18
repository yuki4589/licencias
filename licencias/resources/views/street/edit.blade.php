@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Vía {{ $street->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('street.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('street.show', ['id' => $street->id]) }}" role="button">Volver a vía</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($street, array('route' => array('street.update', $street->id), 'method' => 'put')) !!}

                @include('street.fields')
            
                {!! Form::button('Guardar cambios en la Vía ' . $street->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
