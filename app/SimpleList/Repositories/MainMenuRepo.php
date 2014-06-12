<?php namespace SimpleList\Repositories;

use SimpleList\Entities\MainMenu;

class MainMenuRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de MainMenu
    |
    */

    public static function getUrlInArray($url){
        return MainMenu::where('url','=',$url)->get()->take(1)->toArray();
    }

}