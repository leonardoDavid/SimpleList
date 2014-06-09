@extends('layout')

@section('title')
	SimpleList | Dashboard
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
	    <div class="col-lg-3 col-xs-6">
	        <div class="small-box bg-green">
	            <div class="inner">
	                <h3>
	                    <sup style="font-size: 20px">$</sup>{{ $pays }}
	                </h3>
	                <p>
	                    Adelantos
	                </p>
	            </div>
	            <div class="icon">
	                <i class="fa fa-money"></i>
	            </div>
	            <a href="#" class="small-box-footer">
	                Más info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-xs-6">
	        <div class="small-box bg-teal">
	            <div class="inner">
	                <h3>
	                    {{ $porcent }}<sup style="font-size: 20px">%</sup>
	                </h3>
	                <p>
	                    Porcentaje Mensual
	                </p>
	            </div>
	            <div class="icon">
	                <i class="fa fa-calendar"></i>
	            </div>
	            <a href="#" class="small-box-footer">
	                Más info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-xs-6">
	        <div class="small-box bg-blue">
	            <div class="inner">
	                <h3>
	                    {{ $employed }}
	                </h3>
	                <p>
	                    Empleados
	                </p>
	            </div>
	            <div class="icon">
	                <i class="fa fa-users"></i>
	            </div>
	            <a href="#" class="small-box-footer">
	                Más info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-xs-6">
	        <div class="small-box bg-yellow">
	            <div class="inner">
	                <h3>
	                    {{ $centers }}
	                </h3>
	                <p>
	                    Centros de Costo
	                </p>
	            </div>
	            <div class="icon">
	                <i class="fa fa-archive"></i>
	            </div>
	            <a href="#" class="small-box-footer">
	                Más info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	        </div>
	    </div>
	</div>

	<div class="row">
	    {{ $page }}
	</div>
@stop