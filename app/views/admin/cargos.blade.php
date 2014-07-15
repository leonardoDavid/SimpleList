@extends('layout')

@section('title')
	SimpleList | Administración de Cargos
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
		<!-- Agregar Cargo -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
            	<div class="overlay" data-autohide="1" id="over-add"></div>
            	<div class="afterAdd">
            		<h4>Cargo agregado <i class="fa fa-check"></i></h4>
            		<button class="btn btn-primary" id="addMoreCargos"> Agregar otro Cargo <i class="fa fa-certificate"></i></button>
            	</div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="clearForm" data-original-title="Limpiar"><i class="fa fa-eraser"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title">Agregar Cargo</h3>
                </div>
                {{ Form::open(array('url' => '/admin/cargos/add' , 'id' => 'addCargoForm')) }}
                <div class="box-body">
					<meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
        					<div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="name" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-dollar"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="valor" placeholder="Valor Diario">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <p class="text-red pull-left" id="error-add"></p>
                    <button class="pull-right btn btn-default" id="addCargo"><span>Agregar</span> <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <!-- Buscar/Eliminar centro -->
	    <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <div class="overlay" data-autohide="1" id="over-cargo"></div>
                <div class="box-header">
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="tooltip" id="refresh" data-original-title="Actualizar"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Gestionar Cargos</h3>
                </div>
                <div class="box-body">
					<table id="cargosTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Agregado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cargosListTable as $cargo)
                                <tr>
                                    <td>{{ $cargo->nombre }}</td>
                                    <td>{{ $cargo->valor_dia }}</td>
                                    @if($cargo->active == 1)
                                        <td>Activo</td>
                                    @else
                                        <td>Deshabilitado</td>
                                    @endif
                                    <td>{{ $cargo->created_at }}</td>
                                    <td>
                                        <input type="checkbox" class="flat-orange" name="centerIdOperating" value="{{ $cargo->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <p class="pull-left">A los marcados</p>
                    <div class="pull-right">
                        <button class="btn btn-default" id="editCargo"><span>Editar</span> <i class="fa fa-edit"></i></button>
                        <button class="btn btn-default" id="enabledCargo"><span>Activar</span> <i class="fa fa-check"></i></button>
                        <button class="btn btn-default" id="disbledCargo"><span>Desactivar</span> <i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <button class="col-xs-12 col-md-12 btn btn-success" id="exportAllCargos">Exportar Cargo <span class="fa fa-cloud-download"></span></button>
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

    <div class="modal fade" id="editCargoModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">SimpleList</h4>
                </div>
                <div class="modal-body" id="editForm">
                    <p>Edición de Cargos, recuerde rellenar todo los campos obligatorios</p>
                    <input type="hidden" id="idCargoEdit">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-barcode"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="nameEdit" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-dollar"></span></span>
                                <input type="text" class="form-control" data-requiered="1" id="valorEdit" placeholder="Valor Diario">
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
    var tableDataCargos;
    var cargos;
    var contEdits;

	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        trackSelected();
        $('*[data-autohide="1"]').hide();
        tableDataCargos = $("#cargosTable").DataTable({
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

    $('#addMoreCargos').click(function(event){
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

    $('#disbledCargo').click(function(event) {
        $('#btn-enabled').hide();
        $('#btn-disabled').show();
        $('#confirm-text').text("¿Realmente desea deshabilitar a los Cargos seleccionados?");
        $('#confirm').modal();
    });

    $('#enabledCargo').click(function(event) {
        $('#btn-enabled').show();
        $('#btn-disabled').hide();
        $('#confirm-text').text("¿Realmente desea habilitar a los Cargos seleccionados?");
        $('#confirm').modal();
    });

    $('#btn-enabled').click(function(event){
        $.ajax({
            url: '/admin/cargos/enabled',
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
            url: '/admin/cargos/disabled',
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

    $('input').focus(function(event){
        $(this).parent().removeClass('has-error');
    });

    $('#addCargoForm').submit(function(event){
        event.preventDefault();
        if(validate()){
            $('#over-add').fadeIn();
            $('#addCargo span').text("Agregando...");
            $.ajax({
                url: '/admin/cargos/add',
                type: 'post',
                data: { 
                    name : $('#name').val(),
                    valor : $('#valor').val()
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
                        $('#addCargo span').text("Agregar");
                        setTimeout(function() {
                            $('#error-add').fadeOut();
                        }, 3000);
                    }
                },
                error : function(xhr){
                    $('#error-add').text("Existe un error de conexión, intente más tarde").fadeIn();
                    $('#over-add').fadeOut();
                    $('#addCargo span').text("Agregar");
                    setTimeout(function() {
                        $('#error-add').fadeOut();
                    }, 3000);
                }
            });
        }
    });

    $('#exportAllCargos').click(function(){
        $.ajax({
            url: '/admin/cargos/export',
            type: 'post',
            beforeSend : function(){
                $('#exportAllCargos').attr('disabled',true);
            },
            success : function(response){
                var obj = JSON.parse(response);
                if(obj['status']){
                    $('#exportAllCargos').attr('disabled',false);
                    window.location = obj['download'];
                }
                else{
                    $('#exportAllCargos').attr('disabled',false);
                    $('#msj-error').text(obj['motivo']);
                    $('#list-error').html(obj['mensajes']);
                    $('#error-server').modal();
                }
            },
            error : function(xhr){
                $('#exportAllCargos').attr('disabled',false);
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#error-server').modal();
            }
        });
    });

    $('#btn-next-edit').click(function(){
        if(validateEdit()){
            $('#btn-next-edit , #btn-final-edit').attr('disabled',true);
            $.ajax({
                url: '/admin/cargos/edit',
                type: 'post',
                data: { 
                    name : $('#nameEdit').val(),
                    valor : $('#valorEdit').val(),
                    id : $('#idCargoEdit').val()
                },
                success : function(response){
                    if(response['status']){
                        //Pasar al Siguiente
                        contEdits++;
                        $('#editFrom').text(contEdits);
                        if(contEdits == cargos.length){
                            $('#btn-next-edit').hide();
                            $('#btn-final-edit').attr('disabled',false);
                            $('#statusEdit').hide();
                            $('#statusFinal').show();
                        }
                        else{
                            loadTableEdit(cargos[contEdits]);
                            $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        }
                    }
                    else{
                        $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                        $('#msj-error').text(response['motivo']);
                        $('#list-error').html(response['errores']);
                        if(response['abortEdit'])
                            $('#editCargoModal').modal('hide');
                        $('#error-server').modal();                        
                    }
                },
                error : function(xhr){
                    $('#btn-next-edit , #btn-final-edit').attr('disabled',false);
                    $('#msj-error').text("Existe un error de conexión, la edición de cargos se ha abortado.");
                    $('#editCargoModal').modal('hide');
                    $('#error-server').modal();
                }
            });         
        }
    });

    $('#editCargo').click(function(){
        if(values.length > 0){
            $.ajax({
                url: '/admin/cargos/info',
                type: 'post',
                data: { 'ids': values.toString() },
                beforeSend : function(){
                    $('#editCargo').attr('disabled', true);
                    $('#btn-next-edit,#btn-final-edit').attr('disabled',false).show();
                    $('#statusEdit').show();
                    $('#statusFinal').hide();
                    $('#editFrom').text('0');
                },
                success : function(response){
                    response = JSON.parse(response);
                    if(response['status']){
                        cargos = response['cargos'];
                        $('#editTo').text(cargos.length);
                        $('#editCargo').attr('disabled', false);
                        loadTableEdit(cargos[0]);
                        contEdits = 0;
                        $('#editCargoModal').modal();
                    }
                    else{
                        $('#editCargo').attr('disabled', false);
                        $('#msj-error').text(response['motivo']);
                        $('#error-server').modal();
                    }
                },
                error : function(xhr){
                    $('#editCargo').attr('disabled', false);
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
        $('#valorEdit').val(centro.valor);
        $('#idCargoEdit').val(centro.id);
    }

    function validateEdit(){
        var hasError = true;

        if(!$('#nameEdit').val().trim() != ""){
            $('#nameEdit').parent().addClass('has-error');
            hasError = false;
        }

        if(isNaN($('#valorEdit').val()) || $('#valorEdit').val() == "" ){
            $('#valorEdit').parent().addClass('has-error');
            hasError = false;
        }

        return hasError;
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
        tableDataCargos._fnClearTable();
        $.ajax({
            url: '/admin/cargos/refresh',
            type: 'post',
            beforeSend : function(){
                $('#over-cargo').show();
            },
            success : function(response){
                $.each(response, function(index, val) {
                    var tmp = new Array();
                    tmp.push(response[index]['name']);
                    tmp.push(response[index]['valor']);
                    tmp.push(response[index]['active']);
                    tmp.push(response[index]['added']['date']);
                    tmp.push(response[index]['checkbox']);
                    tableDataCargos._fnAddData(tmp);
                    tableDataCargos._fnReDraw();
                });
                $('#over-cargo').fadeOut();
                trackSelected();
            },
            error : function(xhr){
                $('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-cargo').fadeOut();
                $('#error-server').modal();
            }
        });    
        tableDataCargos._fnReDraw();       
    }

    function clearFormAdd(){
        $('#name').val("");
        $('#valor').val("");
        $('#addCargo span').text("Agregar");
    }

    function validate(){
        var hasError = true;

        if(!$('#name').val().trim() != ""){
            $('#name').parent().addClass('has-error');
            hasError = false;
        }

        if(isNaN($('#valor').val()) || $('#valor').val() == "" ){
            $('#valor').parent().addClass('has-error');
            hasError = false;
        }

        return hasError;
    }
@stop

@section('scripts')
    <script src="/js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.js"></script>
@stop