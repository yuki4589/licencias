@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Actual Etapa de la Licencia
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('licensecurrentstage.index') }}" role="button">Volver al listado</a>
                </div>
            </div>
        </div>

        <div class="panel-body">

            @include('errors.form')

            {!! Form::open(array('route' => 'licensecurrentstage.store', 'files' => true)) !!}

                @include('licenseCurrentStage.fields')

                {!! Form::button('Actual etapa de Licencia', ['class'=> 'btn btn-warning', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
