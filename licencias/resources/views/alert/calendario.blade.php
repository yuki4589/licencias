@extends('layout')

@section('pageTitle')
    Calendario
@endsection

@section('title')
    <div class="col-lg-12">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <i class="fa fa-calendar"></i> Calendario
        </div>
        
    </div>
@endsection

@section('content')    
    <div class="row">
    	<div data-provide="calendar"></div>
    </div>

@endsection


@section('scripts_at_body')
	<script>
		$('.calendar').calendar();
        
    </script>
@endsection