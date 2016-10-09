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

    <div class="pull-right form-inline">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                <button type="button" class="btn" data-calendar-nav="today">Today</button>
                <button type="button" class="btn btn-primary" data-calendar-nav="next">Next >></button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-warning" data-calendar-view="year">Year</button>
                <button type="button" class="btn btn-warning active" data-calendar-view="month">Month</button>
                <button type="button" class="btn btn-warning" data-calendar-view="week">Week</button>
                <button type="button" class="btn btn-warning" data-calendar-view="day">Day</button>
            </div>
        </div>
    <div class="row">
        <div class="col-md-8">
            <h3 id="title"></h3>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
    	   <div id="calendar"></div>
        </div>
    </div>
    <br>
    <!-- Ventana del modal-->
    <div class="modal fade" id="events-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="tituloModal">Alerta</h3>
                </div>
                <div class="modal-body" style="height: 400px">
                    <div class"row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <label>Número de expediente de la licencia;</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-md-offset-1 col-lg-offset-1 col-sm-offset-1 col-xs-offset-1">
                            <p id="modalExpedient"></p>
                        </div>
                    </div>
                    <div class"row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <label>Tipo de alerta:</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-md-offset-1 col-lg-offset-1 col-sm-offset-1 col-xs-offset-1">
                            <p id="modalAlertType"></p>
                        </div>
                    </div>
                    <div class"row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <label>Descripción:</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-md-offset-1 col-lg-offset-1 col-sm-offset-1 col-xs-offset-1">
                            <p id="modalConten" class="text-justify"></p>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">Close</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts_at_body')
	<script>
		(function($) {

            "use strict";
            //creamos la fecha actual
            var objArray;
            $.ajax({
                url : "../../getalertcalendar",
                type : "get",
                async: false,
                success : function(response) {
                    objArray = response;
                },
                error: function(error) {
                    console.log(error);
                }
            });
            var date = new Date();
            var anio = date.getFullYear().toString();
            var mes = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
            var dia  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

            var options = {
                events_source: function (){
                    return JSON.parse(objArray);
                },
                view: 'month',
                tmpl_path: "{{ asset('plugin/bootstrap-calendar-master/tmpls/') }}/",
                tmpl_cache: false,
                language: 'es-ES',
                day: anio + "-" + mes + "-" + dia,
                modal : "#events-modal", 
                modal_type : "ajax", 
                modal_title : function (e) {
                    $('#tituloModal').text(e.title);
                    $('#modalConten').text(e.description);
                    $('#modalExpedient').text(e.license);
                    $('#modalAlertType').text(e.type_alert);
                    return e.title },
                onAfterEventsLoad: function(events) {
                    if(!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');

                    /*$.each(events, function(key, val) {
                        $(document.createElement('li'))
                            .html('<a href="' + val.url + '">' + val.title + '</a>')
                            .appendTo(list);
                    });*/
                },
                onAfterViewLoad: function(view) {
                    $('#title').text(this.getTitle());
                    $('.btn-group button').removeClass('active');
                    $('button[data-calendar-view="' + view + '"]').addClass('active');
                },
                classes: {
                    months: {
                        general: 'label'
                    }
                }
            };

            var calendar = $('#calendar').calendar(options);

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.view($this.data('calendar-view'));
                });
            });

            $('#first_day').change(function(){
                var value = $(this).val();
                value = value.length ? parseInt(value) : null;
                calendar.setOptions({first_day: value});
                calendar.view();
            });

            $('#language').change(function(){
                calendar.setLanguage($(this).val());
                calendar.view();
            });

            $('#events-in-modal').change(function(){
                var val = true;
                calendar.setOptions({modal: val});
            });
            $('#format-12-hours').change(function(){
                var val = $(this).is(':checked') ? true : false;
                calendar.setOptions({format12: val});
                calendar.view();
            });
            $('#show_wbn').change(function(){
                var val = $(this).is(':checked') ? true : false;
                calendar.setOptions({display_week_numbers: val});
                calendar.view();
            });
            $('#show_wb').change(function(){
                var val = $(this).is(':checked') ? true : false;
                calendar.setOptions({weekbox: val});
                calendar.view();
            });
            $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
                //e.preventDefault();
                //e.stopPropagation();
            });
        }(jQuery));
        
    </script>
@endsection