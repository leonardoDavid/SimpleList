@extends('layout')

@section('title')
	SimpleList | Administración
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
		<!-- Agregar empleado -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
            	<div class="overlay" data-autohide="1" id="over-add"></div>
            	<div class="afterAdd">
            		<h4>Centro de Costos agregado <i class="fa fa-check"></i></h4>
            		<button class="btn btn-primary" id="addMoreCenters"> Agregar otro Centro <i class="fa fa-archive"></i></button>
            	</div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-primary btn-sm" data-toggle="tooltip" id="clearForm" data-original-title="Limpiar"><i class="fa fa-eraser"></i></button>
                        <button class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title">Agregar Centro de Costos</h3>
                </div>
                <div class="box-body">
                	{{ Form::open(array('url' => '/admin/empleados/add' , 'id' => 'addCenterForm')) }}
						<meta name="csrf-token" content="{{ csrf_token() }}">
						<div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                            <input type="text" class="form-control" data-requiered="1" id="name" placeholder="Nombre">
                        </div>
                        <div class="box-footer clearfix">
                        	<p class="text-red pull-left" id="error-add"></p>
                            <button class="pull-right btn btn-default" id="addCenter"><span>Agregar</span> <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <!-- Buscar/Eliminar centro -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Gestionar Centros</h3>
                </div>
                <div class="box-body">
					This is a content
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
                    <button class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scriptsInLine')
	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('*[data-autohide="1"]').hide();
    });

    $('#addMoreCenters').click(function(event){
    	clearFormAdd();
    	$('.afterAdd').fadeOut();
    	$('#over-add').fadeOut();
    });

    $('#clearForm').click(function(event) {
    	clearFormAdd();
    });

    function clearFormAdd(){
        $('#name').val("");
        $('#addCenter span').text("Agregar");
    }

    $('input[type="text"]').focus(function(event){
    	$(this).parent().removeClass('has-error');
    });

    $('#addCenterForm').submit(function(event){
    	event.preventDefault();
    	if(validate()){
    		$('#over-add').fadeIn();
    		$('#addCenter span').text("Agregando...");
    		$.ajax({
    			url: '/admin/centros/add',
    			type: 'post',
    			data: { 
    				name : $('#name').val()
    			},
    			success : function(response){
    				if(response['status']){
    					$(".afterAdd").fadeIn();
    				}
    				else{
    					$('#error-add').text(response['motivo']).fadeIn();
                        $('#msj-error').html(response['detalle']);
                        $('#list-error').html(response['errores']);
                        $('#error-server').modal();
    					$('#over-add').fadeOut();
    					$('#addCenter span').text("Agregar");
    					setTimeout(function() {
    						$('#error-add').fadeOut();
    					}, 3000);
    				}
    			},
    			error : function(xhr){
    				$('#error-add').text("Existe un error de conexión, intente más tarde").fadeIn();
    				$('#over-add').fadeOut();
    				$('#addCenter span').text("Agregar");
    				setTimeout(function() {
    					$('#error-add').fadeOut();
    				}, 3000);
    			}
    		});
    	}
    });

    function validate(){
    	if($('#name').val().trim() != "")
    		return true;
    	else{
			$('#name').parent().addClass('has-error');
    		return false;
    	}
    }
@stop