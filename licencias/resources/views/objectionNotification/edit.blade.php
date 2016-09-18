@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Notificación de Reparo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objectionnotification.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('objectionnotification.show', ['id' => $objectionNotification->id]) }}" role="button">Volver al reparo</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($objectionNotification, array('route' => array('objectionnotification.update', $objectionNotification->id), 'method' => 'put')) !!}

                @include('objectionNotification.fields')
            
                {!! Form::button('Guardar cambios en la Notificación del Reparo', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
