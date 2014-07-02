<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Adelanto;
use SimpleList\Entities\Asistencia;

class ReporteRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto a la generacion de la informacion
    | para algun reporte en especifico
    |
    */

    public static function asistencia($filters = null){
        if(is_null($filters)){
            $query = Asistencia::all();
        }
        return $query;
    }

}