<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Adelanto;

class AdelantoRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Adelanto
    |
    */

    public static function sum(){
        return Adelanto::where('active','=','1')->sum('monto');
    }

}