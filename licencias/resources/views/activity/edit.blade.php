@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Actividad {{ $activity->name }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('activity.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('activity.show', ['id' => $activity->id]) }}" role="button">Volver a actividad</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($activity, array('route' => array('activity.update', $activity->id), 'method' => 'put')) !!}

                @include('activity.fields')
            
                {!! Form::button('Guardar cambios en la Actividad ' . $activity->name, ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
