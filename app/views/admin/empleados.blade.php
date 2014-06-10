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
            		<h4>Empleado agregado <i class="fa fa-check"></i></h4>
            		<button class="btn btn-primary" id="addMoreEmployed"> Agregar otro Empleado <i class="fa fa-user"></i></button>
            	</div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-primary btn-sm" data-toggle="tooltip" id="clearForm" data-original-title="Limpiar"><i class="fa fa-eraser"></i></button>
                        <button class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title">Agregar Empleado</h3>
                </div>
                <div class="box-body">
					{{ Form::open(array('url' => '/admin/empleados/add' , 'id' => 'addEmployedForm')) }}
						<meta name="csrf-token" content="{{ csrf_token() }}">
						<div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            <input type="text" class="form-control" data-requiered="1" id="name" placeholder="Nombre">
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-user"></span></span>
                            		<input type="text" class="form-control" data-requiered="1" id="ape_paterno" placeholder="Apellido Paterno">
                        		</div>
                        	</div>
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-user"></span></span>
                            		<input type="text" class="form-control" id="ape_materno" placeholder="Apellido Materno">
                        		</div>
                        	</div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-medkit"></span></span>
                            <input type="text" class="form-control" data-requiered="1" id="prevision" placeholder="Previsión">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
                            <input type="text" class="form-control" data-requiered="1" id="direction" placeholder="Dirección">
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-phone"></span></span>
                            		<input type="text" class="form-control" id="phone" placeholder="Télefono Fijo">
                        		</div>
                        	</div>
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                            		<input type="text" class="form-control" data-requiered="1" id="movil" placeholder="Téñefono Móvil">
                        		</div>
                        	</div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-certificate"></span></span>
                            		<input type="text" class="form-control" data-requiered="1" id="cargo" placeholder="Cargo">
                        		</div>
                        	</div>
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-archive"></span></span>
                            		<input type="text" class="form-control" data-requiered="1" id="centro" placeholder="Centro de Costos">
                        		</div>
                        	</div>
                        </div>
                        <div class="box-footer clearfix">
                        	<p class="text-red pull-left" id="error-add"></p>
                            <button class="pull-right btn btn-default" id="addEmployed"><span>Agregar</span> <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
					{{ Form::close() }}
                </div>
            </div>
        </div>

        <!-- Buscar/Eliminar empleado -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Gestionar Empleados</h3>
                </div>
                <div class="box-body">
					This is a content
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

    $('#addMoreEmployed').click(function(event){
    	clearFormAdd();
    	$('.afterAdd').fadeOut();
    	$('#over-add').fadeOut();
    });

    $('#clearForm').click(function(event) {
    	clearFormAdd();
    });

    $('#addEmployedForm').submit(function(event){
    	event.preventDefault();
    	if(validate()){
    		$('#over-add').fadeIn();
    		$('#addEmployed span').text("Agregando...");
    		$.ajax({
    			url: '/admin/empleados/add',
    			type: 'post',
    			data: { 
    				name : $('#name').val(),
    				ape_paterno : $('#ape_paterno').val(),
    				ape_materno : $('#ape_materno').val(),
    				direction : $('#direction').val(),
    				phone : $('#phone').val(),
    				movil : $('#movil').val(),
    				prevision : $('#prevision').val(),
    				cargo : $('#cargo').val(),
    				centro : $('#centro').val(),
    			},
    			success : function(response){
    				if(response['status']){
    					$(".afterAdd").fadeIn();
    				}
    				else{
    					$('#error-add').text(response['motivo']).fadeIn();
    					$('#over-add').fadeOut();
    					$('#addEmployed span').text("Agregar");
    					setTimeout(function() {
    						$('#error-add').fadeOut();
    					}, 3000);
    				}
    			},
    			error : function(xhr){
    				$('#error-add').text("Existe un error de conexión, intente más tarde").fadeIn();
    				$('#over-add').fadeOut();
    				$('#addEmployed span').text("Agregar");
    				setTimeout(function() {
    					$('#error-add').fadeOut();
    				}, 3000);
    			}
    		});
    		
    	}
    });

    $('input[type="text"]').focus(function(event){
    	$(this).parent().removeClass('has-error');
    });

    function validate(){
    	var hasError = true;
    	$('.input-group input[data-requiered="1"]').each(function(index, el){
    		if($(this).val() == ""){
    			$(this).parent().addClass('has-error');
    			hasError = false;
    		}
    	});
    	if(isNaN($('#phone').val())){
    		$('#phone').parent().addClass('has-error')
    		hasError = false;
    	}
    	if(isNaN($('#movil').val())){
    		$('#movil').parent().addClass('has-error')
    		hasError = false;
    	}

    	return hasError;
    }

    function clearFormAdd(){
    	$('#name').val("");
    	$('#ape_paterno').val("");
    	$('#ape_materno').val("");
    	$('#direction').val("");
    	$('#phone').val("");
    	$('#movil').val("");
    	$('#prevision').val("");
    	$('#cargo').val("");
    	$('#centro').val("");
    }

    $('#phone,#movil').keypress(function(event){
      	if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
          	event.preventDefault();
      	}
  	});

@stop