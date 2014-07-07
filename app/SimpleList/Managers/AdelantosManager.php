<?php namespace SimpleList\Managers;

use SimpleList\Entities\Adelanto;
use SimpleList\Libraries\Util;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class AdelantosManager{
	
	/*
    |--------------------------------------------------------------------------
    | Manager de Adelantos
    |--------------------------------------------------------------------------
    |
    | Estas funciones son utilizadas para agregar montos de adelanto de los 
    | trabajadores durante el mes
    |
    */
    public static function AddPay($fecha = null){
        $values = Input::all();

        $empleado = Util::clearRut($values['user']);
        $monto = $values['monto'];
        $fecha = (is_null($fecha)) ? date('Y-m-d h:i:s') : explode("/", $fecha);
        if(is_array($fecha)){
            $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0].date(' h:i:s');
        }

        try {
            $dato = new Adelanto();
            $dato->monto = $monto;
            $dato->id_empleado = $empleado;
            $dato->active = '1';
            $dato->created_at = $fecha;
            $dato->save();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}