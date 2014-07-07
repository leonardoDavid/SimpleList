<?php

use SimpleList\Entities\Asistencia;
use SimpleList\Entities\Adelanto;

Validator::extend('before_today', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);
	if( (is_array($fecha) && count($fecha) == 3) && ( is_numeric($fecha[0]) && is_numeric($fecha[1]) && is_numeric($fecha[2])) ){
		$enterDate = strtotime($fecha[0]."-".$fecha[1]."-".$fecha[2]);
		$today = strtotime(date("d")."-".date("m")."-".date("Y"));
		return ($enterDate > $today) ? false : true;
	}
	else
		return false;
});

Validator::extend('before_last_date', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);
	if( (is_array($fecha) && count($fecha) == 3) && ( is_numeric($fecha[0]) && is_numeric($fecha[1]) && is_numeric($fecha[2])) ){
		$enterDate = strtotime($fecha[0]."-".$fecha[1]."-".$fecha[2]);

		if($parameters[0] == 'asistencia')
			$maxDateRegister = Asistencia::select('asistencia.created_at as created')->orderBy('created_at','desc')->get();
		elseif ($parameters[0] == 'adelanto')
			$maxDateRegister = Adelanto::select('adelanto.created_at as created')->orderBy('created_at','desc')->get();

		$tmp = explode(" ", $maxDateRegister[0]->created);
		$tmp = explode("-", $tmp[0]);
		$lastDate = strtotime($tmp[2]."-".$tmp[1]."-".$tmp[0]);
		return ($enterDate <= $lastDate) ? true : false;
	}
	else
		return false;
});

Validator::extend('after_init_date', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);
	if( (is_array($fecha) && count($fecha) == 3) && ( is_numeric($fecha[0]) && is_numeric($fecha[1]) && is_numeric($fecha[2])) ){
		$enterDate = strtotime($fecha[0]."-".$fecha[1]."-".$fecha[2]);

		if($parameters[0] == 'asistencia')
			$minDateRegister = Asistencia::select('asistencia.created_at as created')->orderBy('created_at','asc')->get();
		elseif ($parameters[0] == 'adelanto')
			$minDateRegister = Adelanto::select('adelanto.created_at as created')->orderBy('created_at','asc')->get();
		$tmp = explode(" ", $minDateRegister[0]->created);
		$tmp = explode("-", $tmp[0]);
		$firtsDay = strtotime($tmp[2]."-".$tmp[1]."-".$tmp[0]);
		return ($enterDate >= $firtsDay) ? true : false;
	}
	else
		return false;
});