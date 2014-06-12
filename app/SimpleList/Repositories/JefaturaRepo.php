<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Jefatura;
use Illuminate\Support\Facades\View;

class JefaturaRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Jefatura
    |
    */

    public static function getUserData($id){
        $user = Jefatura::getUserData($id)->get();
        return array(
            'name' => $user[0]->name,
            'fullname' => $user[0]->name." ".$user[0]->paterno,
            'added' => $user[0]->added,
            'img' => $user[0]->img
        );
    }

    public static function getUserNotification($userInfo){
        return View::make('menus.userNotification',array(
            'username' => $userInfo['name'],
            'fullname' => $userInfo['fullname'],
            'added' => $userInfo['added'],
            'img' => $userInfo['img']
        ));
    }

}