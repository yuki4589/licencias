@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Préstamo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('loan.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('loan.show', ['id' => $loan->id]) }}" role="button">Volver al préstamo</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($loan, array('route' => array('loan.update', $loan->id), 'method' => 'put')) !!}

                @include('loan.fields')
            
                {!! Form::button('Guardar cambios en el préstamo', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
