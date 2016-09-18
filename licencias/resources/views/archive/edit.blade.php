@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Archivador {{ $archive->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('archive.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('archive.show', ['id' => $archive->id]) }}" role="button">Volver a archivador</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($archive, array('route' => array('archive.update', $archive->id), 'method' => 'put')) !!}

                @include('archive.fields')
            
                {!! Form::button('Guardar cambios en el Archivador ' . $archive->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
