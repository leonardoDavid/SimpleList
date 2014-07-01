<?php

use SimpleList\Entities\Asistencia;

Validator::extend('before_today', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);

	if( (is_array($fecha) && count($fecha) == 3) && ( is_numeric($fecha[0]) && is_numeric($fecha[1]) && is_numeric($fecha[2])) ){
		$enterDate = mktime(0,0,0,$fecha[0],$fecha[1],$fecha[2]);
		$today = mktime(0,0,0,date("d"),date("m"),date("Y"));
		return ($enterDate > $today) ? false : true;
	}
	else
		return false;
});

Validator::extend('after_init_date', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);

	if( (is_array($fecha) && count($fecha) == 3) && ( is_numeric($fecha[0]) && is_numeric($fecha[1]) && is_numeric($fecha[2])) ){
		$enterDate = mktime(0,0,0,$fecha[0],$fecha[1],$fecha[2]);

		$minDateRegister = Asistencia::select('asistencia.created_at as created')->orderBy('created_at','asc')->get();
		$tmp = explode(" ", $minDateRegister[0]->created);
		$tmp = explode("-", $tmp[0]);
		$firtsDay = mktime(0,0,0,$tmp[2],$tmp[1],$tmp[0]);

		return ($enterDate >= $firtsDay) ? true : false;
	}
	else
		return false;
});