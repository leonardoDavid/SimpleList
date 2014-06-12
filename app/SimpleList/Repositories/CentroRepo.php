<?php namespace SimpleList\Repositories;

use SimpleList\Entities\CentroCosto;

class CentroRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de CentroCosto
    |
    */

    public static function count(){
        return CentroCosto::where('active','=','1')->count();
    }

    public static function getSelectCenters(){
        $options = "<option value='0'>Seleccione un Centro</option>";
        $centers = CentroCosto::where('active','=','1')->get();
        foreach ($centers as $row){
            $options .= "<option value='".$row->id."'>".$row->nombre."</option>";
        }
        return $options;
    }

    public static function all(){
        return CentroCosto::all();
    }

}