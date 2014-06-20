@extends('layout')

@section('title')
	SimpleList | Asistencia
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
        <div class="col-xs-12 col-md-12">
            <div class="box box-success">
                <div class="box-header">
                	<div class="pull-right box-tools">
                        <button class="btn btn-success btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-cloud-download"></i>
                    <h3 class="box-title">Exportación Directa CSV</h3>
                </div>
                <div class="box-body">
					<p>
						Modulo en Construcción
					</p>
                </div>
            </div>
        </div>
	    <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-header">
                	<div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Minimizar"><i class="fa fa-minus"></i></button>
                    </div>
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Filtros de Contenido</h3>
                </div>
                <div class="box-body">
					<p>
						Modulo en construcción
					</p>
                </div>
            </div>
        </div>
	</div>
@stop