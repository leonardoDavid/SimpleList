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

    public static function getSelectCenters($id=null){
        $options = "<option value='0'>Seleccione un Centro</option>";
        $centers = CentroCosto::where('active','=','1')->get();
        foreach ($centers as $row){
            $selected = ($row->id == $id) ? "selected" : "";
            $options .= "<option value='".$row->id."' ".$selected.">".$row->nombre."</option>";
        }
        return $options;
    }

    public static function all(){
        return CentroCosto::all();
    }

    public static function find($id){
        return CentroCosto::find($id);
    }

}