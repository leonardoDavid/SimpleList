<?php

Validator::extend('before_today', function($attribute, $value, $parameters){
	$fecha = explode('/',$value);

	if(is_array($fecha) && count($fecha) == 3){
		$enterDate = mktime(0,0,0,$fecha[0],$fecha[1],$fecha[2]);
		$today = mktime(0,0,0,date("d"),date("m"),date("Y"));
		return ($enterDate > $today) ? false : true;
	}
	else
		return false;
});   