@extends('layout')

@section('title')
	SimpleList | Ingreso de Adelantos
@stop

@section('styles')
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
        @if (Session::has('success-system'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Yeah! </strong> {{ Session::get('success-system') }}
            </div>
        @endif
        @if (Session::has('validations-error'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Woou! </strong> Se encontraron los siguientes errores:
                <ul>
                    {{ Session::get('validations-error') }}
                </ul>
            </div>
        @endif
	    <div class="col-xs-12 col-md-12">
            <div class="box box-solid">
                <div class="box-header">
                    <i class="fa fa-money"></i>
                    <h3 class="box-title">Agregar Adelantos</h3>
                </div>
                {{ Form::open(array('url' => '/adelantos/ingresar' , 'id' => 'doPayEarly')) }}
                {{ Form::token() }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <select id="user" name="user" class="form-control" data-requiered="1">
                                    {{ $users }}
                                </select>
                            </div>
                        </div>
                    	<div class="col-xs-12 col-md-4">
                        	<div class="input-group">
                            	<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        		<input id="datePay" name="datePay" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-requiered="1" />
                    		</div>
                    	</div>
                        <div class="col-xs-12 col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-usd"></span></span>
                                <input id="monto" name="monto" type="number" class="form-control" data-requiered="1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <p class="text-red pull-left" id="error-add"></p>
                    <button class="pull-right btn btn-default" id="doPay"><span>Dar Adelanto</span> <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                {{ Form::close() }}
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

@section('scriptsInLine')
	$("#datePay").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

	$('input[data-requiered="1"],select[data-requiered="1"]').focus(function(event){
    	$(this).parent().removeClass('has-error');
    });

    $('#doPay').click(function(event){
    	event.preventDefault();
    	if(validate()){
    		$('.overlay-loading').fadeIn();
            setTimeout(function() {
                $('#doPayEarly').submit();
            }, 800);
    	}
    });

	function validate(){
    	var hasError = true;
    	$('.input-group *[data-requiered="1"]').each(function(index, el){
    		if($(this).val() == "" || $(this).val() == "0"){
    			$(this).parent().addClass('has-error');
    			hasError = false;
    		}
    	});
    	return hasError;
    }
    @yield('scriptsInLine')
@stop

@section('scripts')
	<script src="/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
@stop