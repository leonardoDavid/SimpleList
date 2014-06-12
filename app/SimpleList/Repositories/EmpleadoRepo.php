<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Empleado;
use Illuminate\Support\Facades\Auth;

class EmpleadoRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Empleado
    |
    */

    public static function count(){
        return Empleado::where('active','=','1')->count();
    }

    public static function getEmpleoyesWithoutMe(){
        return Empleado::where('id','!=',Auth::user()->id_empleado)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status')
                        ->get();
    }

}