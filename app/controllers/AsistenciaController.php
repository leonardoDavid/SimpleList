<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;

class AsistenciaController extends BaseController {
    /*
    |--------------------------------------------------------------------------
    | Metodos de Asistencia
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo qu tiene que ver con la parte de tomar asistecia o ver/generar
    | reportes a partir de los filtros entregados
    |
    */
    public function getTake(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('asistencia.take',array(
            'titlePage' => "Asistencia",
            'description' => "",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centers' => CentroRepo::getSelectCenters(),
            'list' => "",
            'dateSelected' => ""
        ));
    }

    public function getListAssistance(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('asistencia.take',array(
            'titlePage' => "Asistencia",
            'description' => "",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centers' => CentroRepo::getSelectCenters(),
            'list' => View::make('asistencia.listEmployes',array(
                            'employes' => "<tr><td colspan='4'>En Construcción :)</td></tr>",
                            'centerName' => 'centerName'
                        )),
            'dateSelected' => ""
        ));
    }

}
