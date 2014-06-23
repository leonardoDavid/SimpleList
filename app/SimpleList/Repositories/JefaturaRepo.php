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

    public static function getSelectJefatura($id=null){
        $options = "<option value='0'>Seleccione una Jefatura</option>";
        $jefatura = Jefatura::join('empleado','jefatura.id_empleado','=','empleado.id')
                        ->where('empleado.active','=','1')
                        ->where('jefatura.active','=','1')->get();
        foreach ($jefatura as $row){
            $selected = ($row->id == $id) ? "selected" : "";
            $options .= "<option value='".$row->id."' ".$selected.">".ucwords($row->nombre)." ".ucwords($row->ape_paterno)."</option>";
        }
        return $options;
    }

}