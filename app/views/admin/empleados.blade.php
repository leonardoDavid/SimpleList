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
            <div class="box box-solid">
            	<div class="overlay" data-autohide="1" id="over-add"></div>
            	<div class="afterAdd">
            		<h4>Empleado agregado <i class="fa fa-check"></i></h4>
            		<button class="btn btn-primary" id="addMoreEmployed"> Agregar otro Empleado <i class="fa fa-user"></i></button>
            	</div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="clearForm" data-original-title="Limpiar"><i class="fa fa-eraser"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
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
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-medkit"></span></span>
                                    <input type="text" class="form-control" data-requiered="1" id="prevision" placeholder="Previsión">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-user-md"></span></span>
                                    <input type="text" class="form-control" data-requiered="1" id="afp" placeholder="AFP">
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-clipboard"></span></span>
                            <select id="tipo" class="form-control" data-requiered="1">
                                {{ $tipoContratos }}
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-thumbs-up"></span></span>
                                    <input id="fecha-ingreso" name="fecha-ingreso" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-requiered="1" placeholder="Fecha de Inicio"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-thumbs-down"></span></span>
                                    <input id="fecha-salida" name="fecha-salida" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-requiered="1" placeholder="Fecha de Termino" disabled/>
                                </div>
                            </div>
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

        <!-- Editar/Activar/Desactivar empleado -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <div class="overlay" data-autohide="1" id="over-employed"></div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="refresh" data-original-title="Actualizar"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
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
                        <button class="btn btn-default" id="editEmployed"><span>Editar</span> <i class="fa fa-edit"></i></button>
                        <button class="btn btn-default" id="enabledEmployed"><span>Activar</span> <i class="fa fa-check"></i></button>
                        <button class="btn btn-default" id="disbledEmployed"><span>Desactivar</span> <i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <button class="col-xs-12 col-md-12 btn btn-success" id="exportAllUsers">Exportar Usuarios <span class="fa fa-cloud-download"></span></button>
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
                    <button class="btn btn-default" id="btn-enabled">Aceptar</button>
                    <button class="btn btn-default" id="btn-disabled">Aceptar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEmployedModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SimpleList</h4>
                </div>
                <div class="modal-body" id="editForm">
                    <input type="hidden" id="rutEmployedEdit">
                    <p>Edición de Empleados, recuerde rellenar todo los campos obligatorios</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control" readonly="true" disabled="true" id="rutEdit" placeholder="RUT">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="nameEdit" placeholder="Nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="ape_paternoEdit" placeholder="Apellido Paterno">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" class="form-control" id="ape_maternoEdit" placeholder="Apellido Materno">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-medkit"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="previsionEdit" placeholder="Previsión">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user-md"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="afpEdit" placeholder="AFP">
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-clipboard"></span></span>
                        <select id="tipoEdit" class="form-control" data-requiered="1">
                            {{ $tipoContratos }}
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-thumbs-up"></span></span>
                                <input id="fecha-ingresoEdit" name="fecha-ingresoEdit" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-requiered="1" placeholder="Fecha de Inicio"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-thumbs-down"></span></span>
                                <input id="fecha-salidaEdit" name="fecha-salidaEdit" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-requiered="1" placeholder="Fecha de Termino" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
                        <input type="text" class="form-control" data-requiered="1" id="directionEdit" placeholder="Dirección">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                <input type="text" class="form-control" id="phoneEdit" placeholder="Teléfono Fijo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="movilEdit" placeholder="Teléfono Móvil">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-certificate"></span></span>
                                <select id="cargoEdit" class="form-control" data-requiered="1">
                                    {{ $cargos }}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-archive"></span></span>
                                <select id="centroEdit" class="form-control" data-requiered="1">
                                    {{ $centers }}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <p id="statusFinal" style="display:none" class="text-green">Proceso completado :)</p>
                    <p class="pull-left" id="statusEdit">Llevas <span id="editFrom">0</span> de <span id="editTo"></span> registros editados</p>
                    <button class="btn btn-default" id="btn-final-edit" data-dismiss="modal">Finalizar</button>
                    <button class="btn btn-success" id="btn-next-edit">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scriptsInLine')
    var tableDataEmployes;
    var empleados;
    var contEdits;

	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('*[data-autohide="1"]').hide();
        trackSelected();
        $("#fecha-salida,#fecha-ingreso,#fecha-salidaEdit,#fecha-ingresoEdit").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
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

    $('#tipo').change(function(){
        $('#fecha-salida').val('');
        if($(this).val() == 1 ||  $(this).val() == 2){
            $('#fecha-salida').attr('disabled',false);
        }
        else{
            $('#fecha-salida').attr('disabled',true);   
        }
    });

    $('#tipoEdit').change(function(){
        $('#fecha-salidaEdit').val('');
        if($(this).val() == 1 ||  $(this).val() == 2){
            $('#fecha-salidaEdit').attr('disabled',false);
        }
        else{
            $('#fecha-salidaEdit').attr('disabled',true);   
        }
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
                    afp : $('#afp').val(),
                    fechaIngreso : $('#fecha-ingreso').val(),
                    fechaSalida : $('#fecha-salida').val(),
                    tipo : $('#tipo').val(),
    				cargo : $('#cargo').val(),
    				centro : $('#centro').val()
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

    $('#btn-next-edit').click(function(){
        if(validateEdit()){
            $('#btn-next-edit , #btn-final-edit').attr('disabled',true);
            $.ajax({
                url: '/admin/empleados/edit',
                type: 'post',
                data: { 
                    rut : $('#rutEdit').val(),
                    name : $('#nameEdit').val(),
                    ape_paterno : $('#ape_paternoEdit').val(),
                    ape_materno : $('#ape_maternoEdit').val(),
                    direction : $('#directionEdit').val(),
                    phone : $('#phoneEdit').val(),
                    movil : $('#movilEdit').val(),
                    prevision : $('#previsionEdit').val(),
                    afp : $('#afpEdit').val(),
                    fechaIngreso : $('#fecha-ingresoEdit').val(),
                    fechaSalida : $('#fecha-salidaEdit').val(),
                    tipo : $('#tipoEdit').val(),
                    cargo : $('#cargoEdit').val(),
                    centro : $('#centroEdit').val()
                },
                success : function(response){
                    if(response['status']){
                        //Pasar al Siguiente
                        contEdits++;
                        $('#editFrom').text(contEdits);
                        if(contEdits == empleados.length){
                            $('#btn-next-edit').hide();
                            $('#btn-final-edit').attr('disabled',false);
                            $('#statusEdit').hide();
                            $('#statusFinal').show();
                        }
                        else{
                            loadTableEdit(empleados[contEdits]);
                            $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        }
                    }
                    else{
                        $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        $('#msj-error').text(response['motivo']);
                        $('#list-error').html(response['errores']);
                        if(response['abortEdit'])
                            $('#editEmployedModal').modal('hide');
                        $('#error-server').modal();                        
                    }
                },
                error : function(xhr){
                    $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                    $('#msj-error').text("Existe un error de conexión, la edición de usuarios se ha abortado.");
                    $('#editEmployedModal').modal('hide');
                    $('#error-server').modal();
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

    $('#rutEdit').keypress(function(event){
        var pass = true;
        if($('#rutEdit').val().length == 9 || ($('#rutEdit').val().slice(-1) == "k" || $('#rutEdit').val().slice(-1) == "K"))
            pass = false;
        else if( (event.which == 107 || event.which == 75) ){
            if(!($('#rutEdit').val().length >=7))
                pass = false;
        }
        else if(event.which != 8 && isNaN(String.fromCharCode(event.which)))
            pass = false;

        if(!pass)
            event.preventDefault();
    });

    $('#exportAllUsers').click(function(){
        $.ajax({
            url: '/admin/empleados/export',
            type: 'post',
            beforeSend : function(){
                $('#exportAllUsers').attr('disabled',true);
            },
            success : function(response){
                var obj = JSON.parse(response);
                if(obj['status']){
                    $('#exportAllUsers').attr('disabled',false);
                    window.location = obj['download'];
                }
                else{
                    $('#exportAllUsers').attr('disabled',false);
                    $('#msj-error').text(obj['motivo']);
                    $('#list-error').html(obj['mensajes']);
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#exportAllUsers').attr('disabled',false);
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#error-server').modal();
            }
        });
    });

    $('#editEmployed').click(function(){
        if(values.length > 0){
            $.ajax({
                url: '/admin/empleados/info',
                type: 'post',
                data: { 'ids': values.toString() },
                beforeSend : function(){
                    $('#editEmployed').attr('disabled', true);
                    $('#btn-next-edit,#btn-final-edit').attr('disabled',false).show();
                    $('#statusEdit').show();
                    $('#statusFinal').hide();
                    $('#editFrom').text('0');
                },
                success : function(response){
                    response = JSON.parse(response);
                    if(response['status']){
                        empleados = response['employes'];
                        $('#editTo').text(empleados.length);
                        $('#editEmployed').attr('disabled', false);
                        loadTableEdit(empleados[0]);
                        contEdits = 0;
                        $('#editEmployedModal').modal();
                    }
                    else{
                        $('#editEmployed').attr('disabled', false);
                        $('#msj-error').text(response['motivo']);
                        $('#error-server').modal();
                    }
                },
                error : function(xhr){
                    $('#editEmployed').attr('disabled', false);
                    $('#msj-error').text('Error de conexión, intentelo más tarde');
                    $('#error-server').modal();
                }
            });
        }
        else{
            $('#msj-error').text('No ha seleccionado ningún empleado para editar');
            $('#error-server').modal();
        }
    });

    function loadTableEdit(empleado){
        $('#rutEdit').val(empleado.rut);
        $('#nameEdit').val(empleado.nombre);
        $('#ape_paternoEdit').val(empleado.paterno);
        $('#ape_maternoEdit').val(empleado.materno);
        $('#directionEdit').val(empleado.direccion);
        $('#phoneEdit').val(empleado.fonoFijo);
        $('#movilEdit').val(empleado.fonoMovil);
        $('#previsionEdit').val(empleado.prevision);
        $('#afpEdit').val(empleado.afp);
        $('#fecha-ingresoEdit').val(empleado.inicioContrato);
        $('#fecha-salidaEdit').val(empleado.finContrato);
        $('#cargoEdit').val(empleado.cargo);
        $('#centroEdit').val(empleado.centroCosto);
        $('#tipoEdit').val(empleado.tipoContrato);
        if($('#tipoEdit').val() == 1 ||  $('#tipoEdit').val() == 2){
            $('#fecha-salidaEdit').attr('disabled',false);
        }
        else{
            $('#fecha-salidaEdit').attr('disabled',true);   
        }
    }

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
    	$('#addEmployedForm .input-group *[data-requiered="1"]').each(function(index, el){
            if(($(this).attr('id') == "fecha-salida" && ($('#tipo').val() != 1 && $('#tipo').val() != 2 ))){
                hasError = true;
            }
    		else if($(this).val() == "" || $(this).val() == "0"){
    			$(this).parent().addClass('has-error');
    			hasError = false;
    		}
    	});
    	if(isNaN($('#phone').val())){
    		$('#phone').parent().addClass('has-error');
    		hasError = false;
    	}
    	if(isNaN($('#movil').val())){
    		$('#movil').parent().addClass('has-error');
    		hasError = false;
    	}

    	return hasError;
    }

    function validateEdit(){
        var hasError = true;
        $('#editForm .input-group *[data-requiered="1"]').each(function(index, el){
            if(($(this).attr('id') == "fecha-salidaEdit" && ($('#tipoEdit').val() != 1 && $('#tipoEdit').val() != 2 ))){
                hasError = true;
            }
            else if($(this).val() == "" || $(this).val() == "0"){
                $(this).parent().addClass('has-error');
                hasError = false;
            }
        });
        if(isNaN($('#phoneEdit').val())){
            $('#phoneEdit').parent().addClass('has-error');
            hasError = false;
        }
        if(isNaN($('#movilEdit').val())){
            $('#movilEdit').parent().addClass('has-error');
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
        $('#afp').val("");
        $('#fecha-ingreso').val("");
    	$('#fecha-salida').val("");
    	$('#cargo').val(0);
    	$('#centro').val(0);
        $('#tipo').val(0);
        $('#addEmployed span').text("Agregar");
    }

@stop

@section('scripts')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
@stop