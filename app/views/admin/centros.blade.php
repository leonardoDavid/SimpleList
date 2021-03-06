@extends('layout')

@section('title')
	SimpleList | Administración de Centros de Costo
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
            		<h4>Centro de Costos agregado <i class="fa fa-check"></i></h4>
            		<button class="btn btn-primary" id="addMoreCenters"> Agregar otro Centro <i class="fa fa-archive"></i></button>
            	</div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="clearForm" data-original-title="Limpiar"><i class="fa fa-eraser"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title">Agregar Centro de Costos</h3>
                </div>
                {{ Form::open(array('url' => '/admin/centros/add' , 'id' => 'addCenterForm')) }}
                <div class="box-body">
					<meta name="csrf-token" content="{{ csrf_token() }}">
					<div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                        <input type="text" class="form-control" data-requiered="1" id="name" placeholder="Nombre">
                    </div>                        
                </div>
                <div class="box-footer clearfix">
                    <p class="text-red pull-left" id="error-add"></p>
                    <button class="pull-right btn btn-default" id="addCenter"><span>Agregar</span> <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <!-- Buscar/Eliminar centro -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <div class="overlay" data-autohide="1" id="over-center"></div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="refresh" data-original-title="Actualizar"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Gestionar Centros</h3>
                </div>
                <div class="box-body">
					<table id="centersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Agregada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($centersListTable as $center)
                                <tr>
                                    <td>{{ $center->nombre }}</td>
                                    @if($center->active == 1)
                                        <td>Activo</td>
                                    @else
                                        <td>Deshabilitado</td>
                                    @endif
                                    <td>{{ $center->created_at }}</td>
                                    <td>
                                        <input type="checkbox" class="flat-orange" name="centerIdOperating" value="{{ $center->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <p class="pull-left">A los marcados</p>
                    <div class="pull-right">
                        <button class="btn btn-default" id="editCenter"><span>Editar</span> <i class="fa fa-edit"></i></button>
                        <button class="btn btn-default" id="enabledCenter"><span>Activar</span> <i class="fa fa-check"></i></button>
                        <button class="btn btn-default" id="disbledCenter"><span>Desactivar</span> <i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <button class="col-xs-12 col-md-12 btn btn-success" id="exportAllCenters">Exportar Centros <span class="fa fa-cloud-download"></span></button>
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

    <div class="modal fade" id="editCenterModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SimpleList</h4>
                </div>
                <div class="modal-body" id="editForm">
                    <p>Edición de Centros de Costo, recuerde rellenar todo los campos obligatorios</p>
                    <div class="input-group">
                        <input type="hidden" id="idCenterEdit">
                        <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                        <input type="text" class="form-control" data-requiered="1" id="nameEdit" placeholder="Nombre">
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
    var tableDataCenters;
    var centros;
    var contEdits;

	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        trackSelected();
        $('*[data-autohide="1"]').hide();
        tableDataCenters = $("#centersTable").DataTable({
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

    $('#addMoreCenters').click(function(event){
    	clearFormAdd();
    	$('.afterAdd').fadeOut();
    	$('#over-add').fadeOut();
    });

    $('#clearForm').click(function(event) {
    	clearFormAdd();
    });

    $('#refresh').click(function(event){
        refreshTable();
    });

    $('#disbledCenter').click(function(event) {
        $('#btn-enabled').hide();
        $('#btn-disabled').show();
        $('#confirm-text').text("¿Realmente desea deshabilitar a los Centros de Costos seleccionados?");
        $('#confirm').modal();
    });

    $('#enabledCenter').click(function(event) {
        $('#btn-enabled').show();
        $('#btn-disabled').hide();
        $('#confirm-text').text("¿Realmente desea habilitar a los Centros de Costos seleccionados?");
        $('#confirm').modal();
    });

    $('#btn-enabled').click(function(event){
        $.ajax({
            url: '/admin/centros/enabled',
            type: 'post',
            data: { 'ids': values.toString() },
            beforeSend:function(){
                $('#over-center').show();
                $('#confirm').modal('hide');
            },
            success : function(response){
                if(response['status']){
                    refreshTable();
                }
                else{
                    $('#msj-error').text(response['motivo']);
                    $('#over-center').fadeOut();
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-center').fadeOut();
                $('#error-server').modal();
            }
        });
    });

    $('#btn-disabled').click(function(event){
        $.ajax({
            url: '/admin/centros/disabled',
            type: 'post',
            data: { 'ids': values.toString() },
            beforeSend:function(){
                $('#over-center').show();
                $('#confirm').modal('hide');
            },
            success : function(response){
                if(response['status']){
                    refreshTable();
                }
                else{
                    $('#msj-error').text(response['motivo']);
                    $('#over-center').fadeOut();
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-center').fadeOut();
                $('#error-server').modal();
            }
        });
    });

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

    $('#exportAllCenters').click(function(){
        $.ajax({
            url: '/admin/centros/export',
            type: 'post',
            beforeSend : function(){
                $('#exportAllCenters').attr('disabled',true);
            },
            success : function(response){
                var obj = JSON.parse(response);
                if(obj['status']){
                    $('#exportAllCenters').attr('disabled',false);
                    window.location = obj['download'];
                }
                else{
                    $('#exportAllCenters').attr('disabled',false);
                    $('#msj-error').text(obj['motivo']);
                    $('#list-error').html(obj['mensajes']);
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#exportAllCenters').attr('disabled',false);
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#error-server').modal();
            }
        });
    });

    $('#btn-next-edit').click(function(){
        if(validateEdit()){
            $('#btn-next-edit , #btn-final-edit').attr('disabled',true);
            $.ajax({
                url: '/admin/centros/edit',
                type: 'post',
                data: { 
                    name : $('#nameEdit').val(),
                    id : $('#idCenterEdit').val()
                },
                success : function(response){
                    if(response['status']){
                        //Pasar al Siguiente
                        contEdits++;
                        $('#editFrom').text(contEdits);
                        if(contEdits == centros.length){
                            $('#btn-next-edit').hide();
                            $('#btn-final-edit').attr('disabled',false);
                            $('#statusEdit').hide();
                            $('#statusFinal').show();
                        }
                        else{
                            loadTableEdit(centros[contEdits]);
                            $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        }
                    }
                    else{
                        $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        $('#msj-error').text(response['motivo']);
                        $('#list-error').html(response['errores']);
                        if(response['abortEdit'])
                            $('#editCenterModal').modal('hide');
                        $('#error-server').modal();                        
                    }
                },
                error : function(xhr){
                    $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                    $('#msj-error').text("Existe un error de conexión, la edición de centros de costo se ha abortado.");
                    $('#editCenterModal').modal('hide');
                    $('#error-server').modal();
                }
            });         
        }
    });

    $('#editCenter').click(function(){
        if(values.length > 0){
            $.ajax({
                url: '/admin/centros/info',
                type: 'post',
                data: { 'ids': values.toString() },
                beforeSend : function(){
                    $('#editCenter').attr('disabled', true);
                    $('#btn-next-edit,#btn-final-edit').attr('disabled',false).show();
                    $('#statusEdit').show();
                    $('#statusFinal').hide();
                    $('#editFrom').text('0');
                },
                success : function(response){
                    response = JSON.parse(response);
                    if(response['status']){
                        centros = response['centers'];
                        $('#editTo').text(centros.length);
                        $('#editCenter').attr('disabled', false);
                        loadTableEdit(centros[0]);
                        contEdits = 0;
                        $('#editCenterModal').modal();
                    }
                    else{
                        $('#editCenter').attr('disabled', false);
                        $('#msj-error').text(response['motivo']);
                        $('#error-server').modal();
                    }
                },
                error : function(xhr){
                    $('#editCenter').attr('disabled', false);
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

    function loadTableEdit(centro){
        $('#nameEdit').val(centro.nombre);
        $('#idCenterEdit').val(centro.id);
    }

    function validateEdit(){
        if($('#nameEdit').val().trim() != "")
            return true;
        else{
            $('#nameEdit').parent().addClass('has-error');
            return false;
        }
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

    function refreshTable(){
        tableDataCenters._fnClearTable();
        $.ajax({
            url: '/admin/centros/refresh',
            type: 'post',
            beforeSend : function(){
                $('#over-center').show();
            },
            success : function(response){
                $.each(response, function(index, val) {
                    var tmp = new Array();
                    tmp.push(response[index]['name']);
                    tmp.push(response[index]['active']);
                    tmp.push(response[index]['added']['date']);
                    tmp.push(response[index]['checkbox']);
                    tableDataCenters._fnAddData(tmp);
                    tableDataCenters._fnReDraw();
                });
                $('#over-center').fadeOut();
                trackSelected();
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-center').fadeOut();
                $('#error-server').modal();
            }
        });    
        tableDataCenters._fnReDraw();       
    }

    function clearFormAdd(){
        $('#name').val("");
        $('#addCenter span').text("Agregar");
    }

    function validate(){
        if($('#name').val().trim() != "")
            return true;
        else{
            $('#name').parent().addClass('has-error');
            return false;
        }
    }
@stop

@section('scripts')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.js"></script>
@stop