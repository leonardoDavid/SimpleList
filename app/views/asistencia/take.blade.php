@extends('layout')

@section('title')
	SimpleList | Control de Asistencia
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
                    <i class="fa fa-calendar"></i>
                    <h3 class="box-title">Tomar Asistencia</h3>
                </div>
                {{ Form::open(array('url' => '/asistencia/tomar' , 'id' => 'takeAssistance')) }}
                {{ Form::token() }}
                <div class="box-body">
					<p>
						Selecciona un centro de costo y un día para pasar lista, si no escojes un día se asumira el día de hoy, si existen datos en relación a ese día se mostraran para asi poder modificarlos.
					</p>
                    <div class="row">
                    	<div class="col-xs-12 col-md-6">
                        	<div class="input-group">
                            	<span class="input-group-addon"><span class="fa fa-archive"></span></span>
                                <select id="centro" name="centro" class="form-control" data-requiered="1" {{ $disabled }}>
                                	{{ $centers }}
                                </select>
                    		</div>
                    	</div>
                    	<div class="col-xs-12 col-md-6">
                        	<div class="input-group">
                            	<span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
                        		<input id="dateList" name="dateList" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" value="{{ $dateSelected }}" data-mask {{ $disabled }}/>
                    		</div>
                    	</div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <p class="text-red pull-left" id="error-add"></p>
                    <button class="pull-right btn btn-default" id="takeBtn" {{ $disabled }}><span>Tomar Asistencia</span> <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                {{ Form::close() }}
            </div>

            {{ $list }}
        </div>
	</div>
@stop

@section('scriptsInLine')
	$("#dateList").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

	$('input[type="text"],select[data-requiered="1"]').focus(function(event){
    	$(this).parent().removeClass('has-error');
    });

    $('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
        checkboxClass: 'icheckbox_flat-orange',
        radioClass: 'iradio_flat-orange'
    });

    $('#takeBtn').click(function(event){
    	event.preventDefault();
    	if(validate()){
    		$('.overlay-loading').fadeIn();
            setTimeout(function() {
                $('#takeAssistance').submit();
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
@stop

@section('scripts')
	<script src="../../js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../../js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../../js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
@stop