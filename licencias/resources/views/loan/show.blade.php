@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Préstamo
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('loan.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('loan.edit', ['id' => $loan->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Licencia:</strong> {{ $loan->license->id }}</p>
            <p><strong>Persona:</strong> {{ $loan->person->first_name }} {{ $loan->person->last_name }}</p>
            <p><strong>Fecha de préstamo:</strong> {{ $loan->loan_date_output }}</p>
            <p><strong>Fecha de devolución:</strong> {{ $loan->giving_back_date_output }}</p>
        </div>
    </div>
@endsection