@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Fichero
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('file.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('file.show', ['id' => $file->id]) }}" role="button">Volver al fichero</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($file, array('route' => array('file.update', $file->id), 'method' => 'put', 'files' => true)) !!}

                @include('file.fields')
            
                {!! Form::button('Guardar cambios en el fichero', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
