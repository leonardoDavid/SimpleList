@extends('layout')

@section('title')
	SimpleList | Mi Perfil
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
		@if (Session::has('error_url'))
			<div class="alert alert-danger alert-dismissable">
	            <i class="fa fa-ban"></i>
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <strong>Woou! </strong> {{ Session::get('error_url') }}
	        </div>
		@endif
	    <div class="col-xs-12 col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-user"></i>
                    <h3 class="box-title">Mis Datos</h3>
                </div>
                <div class="box-body">
					This is a content
                </div>
            </div>
        </div>
	</div>
@stop