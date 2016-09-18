@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Tipo de Usuario
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('usertype.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('usertype.show', ['id' => $userType->id]) }}" role="button">Volver a Tipo de usuario</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($userType, array('route' => array('usertype.update', $userType->id), 'method' => 'put')) !!}

                @include('userType.fields')
            
                {!! Form::button('Guardar cambios en el tipo de usuario ' . $userType->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
