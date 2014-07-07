@extends('layout')

@section('title')
	SimpleList | Reportería de Adelantos
@stop

@section('special-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('styles')
    <link href="/css/plugins/daterangepicker-bs3.min.css" rel="stylesheet" type="text/css" />
@stop

@section('header')
	<h1>
	    {{ $titlePage }}
	    <small>{{ $description }}</small>
	</h1>
	<ol class="breadcrumb">
	    {{ $route }}
	</ol>
@stop

@section('menu')
	{{ $menu }}
@stop

@section('notifications')
	<ul class="nav navbar-nav">
	    {{ $user }}
	</ul>
@stop

@section('contend')
	<div class="row">
        <!-- Exportacion a CSV -->
        <div class="col-xs-12 col-md-12">
            <div class="box box-success">
                <div class="overlay" data-autohide="1" id="over-csv"></div>
                <div class="afterAdd">
                    <h4>Reporte Generado <i class="fa fa-check"></i></h4>
                    <button class="btn btn-primary" id="takeOtherReport"> Exportar otro Reporte <i class="fa fa-cloud-download"></i></button>
                </div>
                <div class="box-header">
                	<div class="pull-right box-tools">
                        <button class="btn btn-success btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-cloud-download"></i>
                    <h3 class="box-title">Exportación Directa CSV</h3>
                </div>
                <div class="box-body">
                    <p>
                        Para realizar la exportación en CSV puede realizar filtros previos para el resultado final y seleccionar un rango de fecha, estos filtros son totalmente opcionales.
                    </p>
                    <p>
                        Si no selecciona ninguna fecha se realizara un reporte de lo que se lleve del mes actual.
                    </p>
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-archive"></span></span>
                                <select id="centro" class="form-control" data-requiered="1">
                                {{ $centros }}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-group"></span></span>
                                <select id="empleado" class="form-control" data-requiered="1">
                                {{ $empleados }}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" class="form-control pull-right" id="rangeReport">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-success" id="filterReport"><span>Filtrar</span> <i class="fa fa-filter"></i></button>
                </div>
            </div>
        </div>

        <!-- Filtro de Vista -->
	    <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-header">
                	<div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Vista Rápida</h3>
                </div>
                <div class="box-body">
					<p>
						Modulo en construcción
					</p>
                </div>
            </div>
        </div>
	</div>

    <div class="modal fade" id="error-server" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">SimpleList</h4>
                </div>
                <div class="modal-body">
                    <p id="msj-error"></p>
                    <p id="list-error"></p>                       
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="/js/plugins/daterangepicker.js" type="text/javascript"></script>
@stop

@section('scriptsInLine')
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('*[data-autohide="1"]').hide();
        $('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
            checkboxClass: 'icheckbox_flat-orange',
            radioClass: 'iradio_flat-orange'
        });
        $('#rangeReport').daterangepicker({ 
            format: 'DD/MM/YYYY'
        });
    });

    $('#filterReport').click(function(event){
        $.ajax({
            url: '/asistencia/reportes/generatecsv',
            type: 'post',
            data: { 
                'values' : getValues()
            },
            beforeSend : function(){
                $('#over-csv').fadeIn();
            },
            success : function(response){
                var obj = JSON.parse(response);
                if(obj['status']){
                    $(".afterAdd").fadeIn();
                    window.location = obj['download'];
                }
                else{
                    $('#msj-error').text(obj['motivo']);
                    $('#list-error').html(obj['mensajes']);
                    $('#over-csv').fadeOut();
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-csv').fadeOut();
                $('#error-server').modal();
            }
        });
    });

    $('#takeOtherReport').click(function(event) {
        $('#centro option:eq(0)').prop('selected', true);
        $('#empleado option:eq(0)').prop('selected', true);
        $('#range').val("");
        $(".afterAdd").fadeOut();
        $('#over-csv').fadeOut();
    });

    function getValues(){
        var checked = 0;
        if($('#ifComments').is(':checked'))
            checked = 1;
        var response = {
            'centro' : $('#centro').val(),
            'empleado' : $('#empleado').val(),
            'range' : $('#rangeReport').val()
        };
        return response;
    }
@stop