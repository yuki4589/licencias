@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Denuncia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('denunciation.index') }}" role="button">Volver al listado</a>
                    @if(isset($license))
                        <a class="btn btn-warning" href="{{ route('license.show', ['id' => $license->id]) }}" role="button">Volver a la Licencia</a>
                    @else
                        <a class="btn btn-warning" href="{{ route('denunciation.show', ['id' => $denunciation->id]) }}" role="button">Volver a la denuncia</a>
                    @endif

                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($denunciation, array('route' => array('denunciation.update', $denunciation->id), 'method' => 'put', 'files' => true)) !!}

                @include('denunciation.fields')
            
                {!! Form::button('Guardar cambios en Denuncia ' . $denunciation->first_name . " " . $denunciation->last_name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
