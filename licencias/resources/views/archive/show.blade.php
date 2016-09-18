@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    Archivador {{ $archive->name }} {{ $archive->place }}
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn btn-warning" href="{{ route('archive.index') }}" role="button">Volver al listado</a>
                    <a class="btn btn-warning" href="{{ route('archive.edit', ['id' => $archive->id]) }}" role="button">Editar</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p><strong>Archivador:</strong> {{ $archive->name }}</p>
        </div>
    </div>
@endsection

