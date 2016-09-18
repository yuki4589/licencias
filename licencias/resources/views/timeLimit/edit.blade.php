@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Limite de Entrega
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('timelimit.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('timelimit.show', ['id' => $timeLimit->id]) }}" role="button">Volver a Límite de Entrega</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($timeLimit, array('route' => array('timelimit.update', $timeLimit->id), 'method' => 'put')) !!}

                @include('timeLimit.fields')
            
                {!! Form::button('Guardar cambios en el límite de entrega', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
