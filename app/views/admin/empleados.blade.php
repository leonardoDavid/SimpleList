@extends('layout')

@section('title')
	SimpleList | Administración
@stop

@section('styles')
    <link href="/css/plugins/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/iCheck/flat/orange.css" rel="stylesheet" type="text/css" />
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
                {{ Form::open(array('url' => '/admin/empleados/add' , 'id' => 'addEmployedForm')) }}
                <div class="box-body">
						<meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                    <input type="text" class="form-control" data-requiered="1" id="rut" placeholder="RUT">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                    <input type="text" class="form-control" data-requiered="1" id="name" placeholder="Nombre">
                                </div>
                            </div>
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
                            		<input type="text" class="form-control" id="phone" placeholder="Teléfono Fijo">
                        		</div>
                        	</div>
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                            		<input type="text" class="form-control" data-requiered="1" id="movil" placeholder="Teléfono Móvil">
                        		</div>
                        	</div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-certificate"></span></span>
                                    <select id="cargo" class="form-control" data-requiered="1">
                                        {{ $cargos }}
                                    </select>
                        		</div>
                        	</div>
                        	<div class="col-xs-12 col-md-6">
	                        	<div class="input-group">
	                            	<span class="input-group-addon"><span class="fa fa-archive"></span></span>
                                    <select id="centro" class="form-control" data-requiered="1">
                                        {{ $centers }}
                                    </select>
                        		</div>
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

        <!-- Buscar/Eliminar empleado -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-info">
                <div class="overlay" data-autohide="1" id="over-employed"></div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-info btn-sm" data-toggle="tooltip" id="refresh" data-original-title="Actualizar"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Gestionar Empleados</h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="employes" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleadosListTable as $employed)
                                <tr>
                                    <td>{{ $employed->rut }}</td>
                                    <td>{{ ucwords($employed->firstname) }}</td>
                                    <td>{{ ucwords($employed->paterno)." ".ucwords($employed->materno) }}</td>
                                    @if($employed->status == 1)
                                        <td>Activo</td>
                                    @else
                                        <td>Deshabilitado</td>
                                    @endif
                                    <td>
                                        <input type="checkbox" class="flat-orange" name="employedIdOperating" value="{{ $employed->rut }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <p class="pull-left">A los marcados</p>
                    <div class="pull-right">
                        <button class="btn btn-default" id="deleteEmployed"><span>Eliminar</span> <i class="fa fa-trash-o"></i></button>
                        <button class="btn btn-default" id="enabledEmployed"><span>Activar</span> <i class="fa fa-check"></i></button>
                        <button class="btn btn-default" id="disbledEmployed"><span>Desactivar</span> <i class="fa fa-times"></i></button>
                    </div>
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

    <div class="modal fade" id="confirm" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">SimpleList</h4>
                </div>
                <div class="modal-body">
                    <p id="confirm-text"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-enabled">Aceptar</button>
                    <button class="btn btn-primary" id="btn-disabled">Aceptar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scriptsInLine')
    var tableDataEmployes;

	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('*[data-autohide="1"]').hide();
        trackSelected();
        tableDataEmployes = $("#employes").DataTable({
            "oLanguage": {
                "sEmptyTable": "Sin Datos",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sSearch": "Buscar:",
                "sSearchPlaceholder": "Search...",
                "sZeroRecords": "No se encontraron coincidencias",
                "oPaginate": {
                    "sFirst": "Primera",
                    "sLast": "Última",
                    "sNext": "",
                    "sPrevious": "",
                },
                "sLengthMenu": 'Mostrar <select class="form-control">'+
                    '<option value="5">5</option>'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="-1">Todos</option>'+
                    '</select>'+' regsitros'
            }
        });
    });

    $('#addMoreEmployed').click(function(event){
    	clearFormAdd();
    	$('.afterAdd').fadeOut();
    	$('#over-add').fadeOut();
    });

    $('#refresh').click(function(event){
        refreshTable();
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
                    rut : $('#rut').val(),
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
                        $('#msj-error').html(response['detalle']);
                        $('#list-error').html(response['errores']);
                        $('#error-server').modal();
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

    $('input[type="text"],select[data-requiered="1"]').focus(function(event){
    	$(this).parent().removeClass('has-error');
    });

    $('#disbledEmployed').click(function(event) {
        $('#btn-enabled').hide();
        $('#btn-disabled').show();
        $('#confirm-text').text("¿Realmente desea deshabilitar a los empleados seleccionados?");
        $('#confirm').modal();
    });

    $('#enabledEmployed').click(function(event) {
        $('#btn-enabled').show();
        $('#btn-disabled').hide();
        $('#confirm-text').text("¿Realmente desea habilitar a los empleados seleccionados?");
        $('#confirm').modal();
    });

    $('#btn-enabled').click(function(event){
        $.ajax({
            url: '/admin/empleados/enabled',
            type: 'post',
            data: { 'ids': values.toString() },
            beforeSend:function(){
                $('#over-employed').show();
                $('#confirm').modal('hide');
            },
            success : function(response){
                if(response['status']){
                    refreshTable();
                }
                else{
                    $('#msj-error').text(response['motivo']);
                    $('#over-employed').fadeOut();
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-employed').fadeOut();
                $('#error-server').modal();
            }
        });
    });

    $('#btn-disabled').click(function(event){
        $.ajax({
            url: '/admin/empleados/disabled',
            type: 'post',
            data: { 'ids': values.toString() },
            beforeSend:function(){
                $('#over-employed').show();
                $('#confirm').modal('hide');
            },
            success : function(response){
                if(response['status']){
                    refreshTable();
                }
                else{
                    $('#msj-error').text(response['motivo']);
                    $('#over-employed').fadeOut();
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-employed').fadeOut();
                $('#error-server').modal();
            }
        });
    });

    $('#phone,#movil').keypress(function(event){
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault();
        }
    });

    $('#rut').keypress(function(event){
        var pass = true;
        if($('#rut').val().length == 9 || ($('#rut').val().slice(-1) == "k" || $('#rut').val().slice(-1) == "K"))
            pass = false;
        else if( (event.which == 107 || event.which == 75) ){
            if(!($('#rut').val().length >=7))
                pass = false;
        }
        else if(event.which != 8 && isNaN(String.fromCharCode(event.which)))
            pass = false;

        if(!pass)
            event.preventDefault();
    });

    function refreshTable(){
        tableDataEmployes._fnClearTable();
        $.ajax({
            url: '/admin/empleados/refresh',
            type: 'post',
            beforeSend : function(){
                tableDataEmployes._fnClearTable();
                $('#over-employed').show();
            },
            success : function(response){
                $.each(response, function(index, val) {
                    var tmp = new Array();
                    tmp.push(response[index]['rut']);
                    tmp.push(response[index]['name']);
                    tmp.push(response[index]['lastname']);
                    tmp.push(response[index]['active']);
                    tmp.push(response[index]['checkbox']);
                    tableDataEmployes._fnAddData(tmp);
                    tableDataEmployes._fnReDraw();
                });
                $('#over-employed').fadeOut();
                trackSelected();
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-employed').fadeOut();
                $('#error-server').modal();
            }
        });  
        tableDataEmployes._fnReDraw();    
    }

    function trackSelected(){
        $('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
            checkboxClass: 'icheckbox_flat-orange',
            radioClass: 'iradio_flat-orange'
        });
        $('input[type="checkbox"]').attr('checked',false);
        values = [];
        $('input[type="checkbox"]').on('ifChecked', function(event){
            values.push($(this).val());
        });
        $('input[type="checkbox"]').on('ifUnchecked', function(event){
            values.pop($(this).val());
        });        
    }

    function validate(){
    	var hasError = true;
    	$('.input-group *[data-requiered="1"]').each(function(index, el){
    		if($(this).val() == "" || $(this).val() == "0"){
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
        $('#rut').val("");
    	$('#name').val("");
    	$('#ape_paterno').val("");
    	$('#ape_materno').val("");
    	$('#direction').val("");
    	$('#phone').val("");
    	$('#movil').val("");
    	$('#prevision').val("");
    	$('#cargo').val(0);
    	$('#centro').val(0);
        $('#addEmployed span').text("Agregar");
    }

@stop

@section('scripts')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.js"></script>
@stop