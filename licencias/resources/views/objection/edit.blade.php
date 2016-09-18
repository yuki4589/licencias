@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Editar Reparo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('objection.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('objection.show', ['id' => $objection->id]) }}" role="button">Volver al reparo</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::model($objection, array('route' => array('objection.update', $objection->id), 'method' => 'put', 'files' => true)) !!}

                @include('objection.fields')
            
                {!! Form::button('Guardar cambios en el Reparo', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
