<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Permisos;
use Illuminate\Support\Facades\Auth;

class PermisosRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de MainMenu
    |
    */

    public static function hasAccessInArray($menu_id,$type){
    	return Permisos::where('menu_id','=',$menu_id)
								->where('user_id','=',Auth::user()->id)
								->where('type','=',$type)
								->get()->toArray();
    }

}