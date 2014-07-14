<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Cargo;

class CargoRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Jefatura
    |
    */

    public static function getSelectCargos(){
        $options = "<option value='0'>Seleccione un Cargo</option>";
        $centers = Cargo::where('active','=','1')->get();
        foreach ($centers as $row){
            $options .= "<option value='".$row->id."'>".$row->nombre."</option>";
        }
        return $options;
    }

    public static function all(){
        return Cargo::all();
    }

}